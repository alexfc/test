<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 2018-11-14
 * Time: 11:58
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function index()
    {
        return $this->render('base.html.twig');
    }
}