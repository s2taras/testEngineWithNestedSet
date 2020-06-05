<?php

namespace Task1\View;

class LoginPage implements PageInterface
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
                <title>Login form</title>
            </head>
            <body>
                <h3><?php echo $data['message'] ? $data['message'] : '' ; ?></h3>
                <h3><?php echo $data['ban_time'] ? 'Try again in ' . self::getMinutes($data['ban_time']) : '' ; ?></h3>

                <form action="" method="post">
                    <p>
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" value="" required>
                    </p>
                    <p>
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" value="" required>
                    </p>
                    <p>
                        <button type="submit">Login</button>
                        <button type="reset">Cancel</button>
                    </p>
                </form>
            </body>
        </html>

        <?php
        return ob_get_contents();
    }

    /**
     * @param int $seconds
     * @return string
     */
    public static function getMinutes(int $seconds): string
    {
        $inSeconds = $seconds - strtotime('now');
        return floor($inSeconds/60) ."min ". $inSeconds % 60 .'sec';
    }
}