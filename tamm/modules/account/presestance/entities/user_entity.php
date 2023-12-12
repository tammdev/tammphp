<?php

namespace Tamm\Modules\Account\Entities;

/**
 * @Entity(table="users")
 */
class UserEntity
{
    /**
     * @Id
     * @Column(name="user_id", type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(name="username", type="string")
     * @Unique
     */
    private $username;

    /**
     * @Column(name="email", type="string")
     * @Unique
     */
    private $email;

    // /**
    //  * @OneToMany(targetEntity="Address", mappedBy="user")
    //  */
    // private $addresses;

    // ... additional properties and methods ...
}
