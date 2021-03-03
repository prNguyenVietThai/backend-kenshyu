<?php
    class UserPage {
        private $users;
        public function __construct($users){
            $this->$users = $users;
        }

        public function render() {
            echo("
                <div>
                    <p>USER LIST</p>
                </div>
            ");
        }
    }
?>
