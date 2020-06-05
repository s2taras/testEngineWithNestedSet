<?php

namespace Task3\View;

class ShopPage
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
                <link href="../assetic/css/bootstrap.min.css" rel="stylesheet">
                <link href="../assetic/css/bootstrap-theme.min.css" rel="stylesheet">
            </head>
            <body>
                <div class="container theme-showcase">
                    <div class="jumbotron">

                        <h1>Clothes Shop</h1>

                        <?php if (count($data['products']) > 0) : ?>

                            <ul class="list-group">

                                <?php foreach ($data['products'] as $item) : ?>

                                    <li class="list-group-item">
                                        <?php echo $item['title']; ?>&nbsp;|&nbsp;
                                        <?php echo $item['price']; ?>&nbsp;|&nbsp;
                                        <?php echo $item['region']; ?>&nbsp;|&nbsp;
                                        <?php echo implode(', ', $item['tags']); ?>&nbsp;|&nbsp;
                                        <?php echo implode(', ', $item['categories']); ?>
                                    </li>

                                <?php endforeach; ?>

                            </ul>

                            <div>
                                <?php for ($i=1; $i <= $data['pagination']['totalPages']; $i++) : ?>
                                    <?php if ($i == $data['pagination']['currentPage']) : ?>

                                        <a class="btn btn-success" onclick="return false;" href="?page=<?php echo $i?>"><?php echo $i ?></a>

                                    <?php else: ?>

                                        <a class="btn btn-sm btn-default" href="?page=<?php echo $i?>"><?php echo $i ?></a>

                                    <?php endif; ?>
                                <?php endfor ?>
                            </div>

                        <?php else : ?>

                            <h4>Empty list</h4>

                        <?php endif; ?>

                    </div>
                </div>

            </body>
        </html>

        <?php
        return ob_get_contents();
    }
}