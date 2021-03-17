<?php

require_once('MZMBO_WPUnitTestCase.php');
require_once('Test_Options.php');

/**
 * Class ScheduleDisplayTest
 *
 * @package Mz_Mindbody_Api
 * Check https://github.com/rnagle/wordpress-unit-tests/blob/master/includes/factory.php for details on WP  unit test factory
 */

/**
 * Sample test case.
 */
class ScheduleDisplayTest extends MZMBO_WPUnitTestCase
{

    /**
     * Test Results from MBO Sandbox account
     */
    function test_get_classes_result()
    {
        parent::setUp();

        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Core\MZ_Mindbody_Api'));
        // Manually initialize static variable.
        MZ_Mindbody\Inc\Core\MZ_Mindbody_Api::$basic_options = get_option('mz_mbo_basic');
        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Schedule\Retrieve_Schedule'));
        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule();
        $time_frame = $schedule_object->time_frame();
        $this->assertTrue(count($time_frame) === 2);
        $response = $schedule_object->get_mbo_results();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response[0]));
        $this->assertTrue(is_string($response[0]['StartDateTime']));
        $this->assertTrue(is_string($response[0]['ClassDescription']['Name']));
        parent::tearDown();
    }

    /**
     * Confirm that horizontal schedule display method is operational
     */
    function test_sort_classes_by_date_then_time()
    {

        parent::setUp();

        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Schedule\Retrieve_Schedule'));

        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule();

        $response = $schedule_object->get_mbo_results();

        $sequenced_classes = $schedule_object->sort_classes_by_date_then_time();

        /*
         * Test that first date is today
         */
        $key = reset($sequenced_classes);
        $first = array_shift($key);
        $first_event_date = date('Y-m-d', strtotime($first->startDateTime));
        $now = date('Y-m-d', current_time('timestamp'));
        $this->assertTrue($first_event_date == $now);

        /*
         * Each subsequent date should be equal to or greater than current,
         * which is set according to first date in the matrix.
         */
        foreach ($sequenced_classes as $date => $class) {
            $current = isset($current) ? $current : $date;
            $this->assertTrue($date >= $current);
        }

        parent::tearDown();
    }

    /**
     * Confirm that grid schedule display method is operational
     */
    function test_sort_classes_by_time_then_date()
    {

        parent::setUp();

        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Schedule\Retrieve_Schedule'));

        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule();

        $response = $schedule_object->get_mbo_results();

        $sequenced_classes = $schedule_object->sort_classes_by_time_then_date();

        /*
         * Each subsequent time slot should be equal to or greater than current,
         * which is set according to first time-like key in the matrix.
         */
        foreach ($sequenced_classes as $time_like_key => $class) {
            $current = isset($current) ? $current : $time_like_key;
            $this->assertTrue($time_like_key >= $time_like_key);
            $this->assertTrue(is_array($class['classes']));
            // Is it an array of seven days?
            $this->assertTrue(count($class['classes']) === 7);
        }

        parent::tearDown();
    }

    /**
     * Confirm that day schedule display works.
     */
    function test_day_schedule_result()
    {

        parent::setUp();

        // For some reason this test fails without specifying locations attribute.
        // I don't know why for the day display the locations attr isn't receiving
        // the default value.
        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule(array('type' => 'day', 'locations' => array(1)));

        $response = $schedule_object->get_mbo_results();

        $sequenced_classes = $schedule_object->sort_classes_by_time_then_date();

        /*
         * Each subsequent date should be equal to or greater than current,
         * which is set according to first date in the matrix.
         */
        foreach ($sequenced_classes as $date => $class) {
            $current = isset($current) ? $current : $date;
            $this->assertTrue($date >= $current);
        }

        parent::tearDown();
    }

    /**
     * Test Time Frame
     */
    function test_time_frame()
    {
        parent::setUp();

        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Core\MZ_Mindbody_Api'));
        // Manually initialize static variable.
        MZ_Mindbody\Inc\Core\MZ_Mindbody_Api::$basic_options = get_option('mz_mbo_basic');
        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Schedule\Retrieve_Schedule'));
        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule();
        $time_frame = $schedule_object->time_frame(strtotime('+1 week'));
        $this->assertTrue(count($time_frame) === 2);
        $response = $schedule_object->get_mbo_results();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response[0]));
        $this->assertTrue(is_string($response[0]['StartDateTime']));
        $this->assertTrue(is_string($response[0]['ClassDescription']['Name']));
        parent::tearDown();
    }

    /**
     * Test Following Week
     */
    function test_following_week()
    {
        parent::setUp();

        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Core\MZ_Mindbody_Api'));
        // Manually initialize static variable.
        MZ_Mindbody\Inc\Core\MZ_Mindbody_Api::$basic_options = get_option('mz_mbo_basic');
        $this->assertTrue(class_exists('MZ_Mindbody\Inc\Schedule\Retrieve_Schedule'));
        $schedule_object = new MZ_Mindbody\Inc\Schedule\Retrieve_Schedule();
        $time_frame = $schedule_object->time_frame(strtotime('+1 week'));
        $this->assertTrue(count($time_frame) === 2);
        $response = $schedule_object->get_mbo_results();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response[0]));
        $this->assertTrue(is_string($response[0]['StartDateTime']));
        $this->assertTrue(is_string($response[0]['ClassDescription']['Name']));
        parent::tearDown();
    }
}
