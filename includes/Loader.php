<?php
/**
 * Register actions and filters for the plugin.
 */

namespace Devllo\WineEssentials;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Loader {

    /**
     * Actions registered with WordPress.
     *
     * @var array
     */
    protected $actions = array();

    /**
     * Filters registered with WordPress.
     *
     * @var array
     */
    protected $filters = array();

    /**
     * Add a new action to collection.
     */
    public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->actions[] = compact( 'hook', 'component', 'callback', 'priority', 'accepted_args' );
    }

    /**
     * Add a new filter to collection.
     */
    public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
        $this->filters[] = compact( 'hook', 'component', 'callback', 'priority', 'accepted_args' );
    }

    /**
     * Register the filters and actions with WordPress.
     */
    public function run() {
        foreach ( $this->filters as $hook ) {
            add_filter( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }

        foreach ( $this->actions as $hook ) {
            add_action( $hook['hook'], array( $hook['component'], $hook['callback'] ), $hook['priority'], $hook['accepted_args'] );
        }
    }
}
