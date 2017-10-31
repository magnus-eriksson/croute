<?php namespace MaerTest\Testing;

/**
 * @routePrefix /before
 * @routeBefore helloBefore
 * @routeAfter  helloAfter
 */
class NamespaceController
{
    /**
     * @route GET /
     * @routeName get.index
     * @routeBefore getIndexBefore
     */
    public function getIndex() {}

    /**
     * @route POST /root
     * @routeName post.root
     * @routeAfter postIndexAfter
     */
    public function postRoot() {}
}
