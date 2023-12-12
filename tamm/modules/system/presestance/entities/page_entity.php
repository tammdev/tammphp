<?php

namespace Tamm\Modules\System\Entities;

/**
 * @Entity(table="users")
 */
class PageEntity
{
    /**
     * @Id
     * @Column(name="page_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="slug", type="string")
     * @Unique
     */
    private $slug;

    /**
     * @Column(name="title", type="string")
     */
    private $title;

    /**
     * @Column(name="content", type="string")
     */
    private $content;


    // ... additional properties and methods ...
}
