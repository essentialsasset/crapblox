<?php
namespace Crapblox\Views;
use \Crapblox\Models\Auth;

class Gmod extends \Crapblox\Views\ViewBase {
    public function View() {
        echo $this->Twig->render('Gmod.twig', array(
        ));
    }
}