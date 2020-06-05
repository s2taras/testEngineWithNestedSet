<?php

namespace Task1\View;

class AccountPage implements PageInterface
{
    /**
     * @param array $data
     * @return string
     */
    public static function view(array $data): string
    {
        ob_start(); ?>

        <!Doctype html>
        <html>
            <head>
                <title>Account</title>
            </head>
            <body>
                <h2>Account page</h2>

                <h4>Welcome, <?php echo $data['session'] ?></h4>

                <form action="/logout" method="get">
                    <button type="submit">Logout</button>
                </form>
            </body>
        </html>

        <?php
        return ob_get_contents();
    }
}