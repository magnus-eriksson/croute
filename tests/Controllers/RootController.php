<?php
/**
 * @routePrefix /Before
 * @routeBefore helloBefore
 * @routeAfter  helloAfter
 */
class RootController
{
    /**
     * @route GET /
     */
    public function getIndex() {}

    /**
     * @route POST /root
     */
    public function postRoot() {}
}
