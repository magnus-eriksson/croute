<?php
class RootController
{
    /**
     * Should be parsed
     *
     * @route GET /
     */
    public function getIndex() {}

    /**
     * Should be parsed
     *
     * @route POST /root
     * @routeBefore rootBefore1
     * @routeBefore rootBefore2
     * @routeAfter rootAfter
     */
    public function postRoot() {}

    /**
     * Invalid route that should not be parsed
     *
     * @route POST
     * @routeName
     */
    public function invalid() {}
}
