<?php

/*
 * This file is part of the Fxp package.
 *
 * (c) François Pluchino <francois.pluchino@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Fxp\Component\Config\Tests\Listener;

use Doctrine\Common\Annotations\AnnotationReader;
use Fxp\Component\Config\Exception\LogicException;
use Fxp\Component\Config\Exception\UnexpectedValueException;
use Fxp\Component\Config\Listener\ControllerSubscriber;
use Fxp\Component\Config\Tests\Fixtures\Annotation\MockAnnotation;
use Fxp\Component\Config\Tests\Fixtures\Annotation\MockArrayAnnotation;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockArrayController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockCallableController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockInvalidMultipleAnnotationClassController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockInvalidTypeAnnotationClassAndMethodController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockOnlyClassController;
use Fxp\Component\Config\Tests\Fixtures\Controller\MockOnlyMethodController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author François Pluchino <francois.pluchino@gmail.com>
 *
 * @internal
 */
final class ControllerSubscriberTest extends TestCase
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var ControllerSubscriber
     */
    protected $listener;

    protected function setUp(): void
    {
        $this->request = $this->createRequest();
        $this->listener = new ControllerSubscriber(new AnnotationReader());

        // trigger the auto loading of the mock annotations
        class_exists(MockAnnotation::class);
        class_exists(MockArrayAnnotation::class);
    }

    protected function tearDown(): void
    {
        $this->request = null;
        $this->listener = null;
    }

    public function testGetSubscribedEvents(): void
    {
        $expected = [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];

        static::assertSame($expected, ControllerSubscriber::getSubscribedEvents());
    }

    public function testMockAnnotation(): void
    {
        $controller = new MockController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);

        static::assertArrayHasKey('_mock', $this->request->attributes->all());
        static::assertInstanceOf(MockAnnotation::class, $this->request->attributes->get('_mock'));
    }

    public function testMockAnnotationWithCallableController(): void
    {
        $controller = new MockCallableController();

        $event = $this->getControllerEvent($controller, $this->request);
        $this->listener->onKernelController($event);

        static::assertArrayHasKey('_mock', $this->request->attributes->all());
        static::assertInstanceOf(MockAnnotation::class, $this->request->attributes->get('_mock'));
    }

    public function testMockAnnotationWithFunctionController(): void
    {
        $controller = static function (): void {};

        $event = $this->getControllerEvent($controller, $this->request);
        $this->listener->onKernelController($event);

        static::assertCount(0, $this->request->attributes->all());
    }

    public function testMockAnnotationOnlyInMethod(): void
    {
        $controller = new MockOnlyMethodController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);

        static::assertArrayHasKey('_mock', $this->request->attributes->all());
        static::assertInstanceOf(MockAnnotation::class, $this->request->attributes->get('_mock'));
    }

    public function testMockAnnotationOnlyInClass(): void
    {
        $controller = new MockOnlyClassController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);

        static::assertArrayHasKey('_mock', $this->request->attributes->all());
        static::assertInstanceOf(MockAnnotation::class, $this->request->attributes->get('_mock'));
    }

    public function testMockArrayAnnotation(): void
    {
        $controller = new MockArrayController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);

        static::assertArrayHasKey('_mock', $this->request->attributes->all());
        $mocks = $this->request->attributes->get('_mock');

        static::assertIsArray($mocks);
        static::assertCount(2, $mocks);

        static::assertInstanceOf(MockAnnotation::class, $mocks[0]);
        static::assertInstanceOf(MockAnnotation::class, $mocks[1]);
    }

    public function testInvalidMultipleMockAnnotations(): void
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Multiple "mock" annotations are not allowed');

        $controller = new MockInvalidMultipleAnnotationClassController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);
    }

    public function testInvalidTypeMockAnnotations(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Configurations should both be an array or both not be an array');

        $controller = new MockInvalidTypeAnnotationClassAndMethodController();

        $event = $this->getControllerEvent([$controller, 'fooAction'], $this->request);
        $this->listener->onKernelController($event);
    }

    private function createRequest(array $attributes = []): Request
    {
        return new Request([], [], $attributes);
    }

    /**
     * @param callable $controller The controller
     * @param Request  $request    The request
     *
     * @throws
     *
     * @return ControllerEvent
     */
    private function getControllerEvent($controller, Request $request): ControllerEvent
    {
        $mockKernel = $this->getMockForAbstractClass(Kernel::class, ['', '']);

        return new ControllerEvent($mockKernel, $controller, $request, HttpKernelInterface::MASTER_REQUEST);
    }
}
