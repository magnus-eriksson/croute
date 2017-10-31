<?php namespace MaerTest\Testing;

/**
 * @routePrefix /namespace
 * @routeBefore classBefore
 * @routeAfter  classfter
 */
class NamespaceController
{
    /**
     * @route GET /
     * @routeName namespace.index
     * @routeBefore getIndexBefore
     */
    public function getIndex() {}

    /**
     * @route POST /root
     * @routeName namespace.root
     * @routeAfter postIndexAfter
     */
    public function postRoot() {}
}
