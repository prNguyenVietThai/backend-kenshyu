<?php
class NotfoundPage {
    public function __construct() {

    }

    public function view(){
        return ("
                <div class='not-found'>
                    Page not found
                </div>
            ");
    }
}