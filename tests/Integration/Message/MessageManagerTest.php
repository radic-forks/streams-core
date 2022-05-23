<?php

namespace Streams\Tests\Core\Integration\Message;

use Streams\Core\Support\Facades\Messages;
use Streams\Tests\Core\Integration\CoreTestCase;

class MessageManagerTest extends CoreTestCase
{
    public function test_it_adds_messages()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        Messages::add('error', 'Test error!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ],
            '3bc509e2a92608b76573754dd314af7b' => [
                'content' => 'Test error!',
                'type' => 'error',
            ]
        ], Messages::get());
    }

    public function test_it_pulls_messages()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        $pulled = Messages::pull();

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], $pulled);

        $this->assertEquals([], Messages::get());
    }

    public function test_it_adds_error_messages()
    {
        Messages::error('Test error!');

        $this->assertEquals([
            '3bc509e2a92608b76573754dd314af7b' => [
                'content' => 'Test error!',
                'type' => 'error',
            ]
        ], Messages::get());
    }

    public function test_it_adds_info_messages()
    {
        Messages::info('Test info!');

        $this->assertEquals([
            '62ca1ba26e5877a6bb92834ed4fff98a' => [
                'content' => 'Test info!',
                'type' => 'info',
            ]
        ], Messages::get());
    }

    public function test_it_adds_success_messages()
    {
        Messages::success('Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());
    }

    public function test_it_adds_warning_messages()
    {
        Messages::warning('Test warning!');

        $this->assertEquals([
            '3c3a0bf4647e539fa4a79ba19f5128a1' => [
                'content' => 'Test warning!',
                'type' => 'warning',
            ]
        ], Messages::get());
    }

    public function test_it_adds_danger_messages()
    {
        Messages::danger('Test danger!');

        $this->assertEquals([
            '50e3350b0d9423826f09dfe180861d7e' => [
                'content' => 'Test danger!',
                'type' => 'danger',
            ]
        ], Messages::get());
    }

    public function test_it_adds_important_messages()
    {
        Messages::important('Test important!');

        $this->assertEquals([
            '2d75e4dda3986ac14c74f8ac0f3fc42a' => [
                'content' => 'Test important!',
                'type' => 'important',
            ]
        ], Messages::get());
    }

    public function test_it_flushes_messages()
    {
        Messages::add('success', 'Test success!');

        $this->assertEquals([
            '49f720506984ca5b5e97789d66d876e1' => [
                'content' => 'Test success!',
                'type' => 'success',
            ]
        ], Messages::get());

        Messages::flush();

        $this->assertEquals([], Messages::get());
    }
}
