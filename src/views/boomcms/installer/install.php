<!DOCTYPE html>
<html dir="ltr" lang="en-gb" class="boom">
    <head>
        <title>Install BoomCMS</title>
        <meta name="robots" content="nofollow,noindex">

        <link rel="stylesheet" type="text/css" href="/vendor/boomcms/boom-core/css/cms.css" />
        <link rel="stylesheet" type="text/css" href="/vendor/boomcms/boom-installer/css/boomcms-installer.css" />
    </head>

    <body id="boomcms-install">
        <header role="banner">
            <img src="/vendor/boomcms/boom-core/img/logo.png" alt="BoomCMS logo" id="logo" />
            <h1>Install BoomCMS</h1>
        </header>

        <main>
            <form method='post'>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">

                <?php if ($installer->databaseNeedsInstall()): ?>
                    <fieldset>
                        <legend>Database Connection</legend>
                        <p>Enter the database connection details below.</p>
                        <p>You will need to ensure that the database already exists.</p>

                        <p>
                            <label for="db.user">Username</label>
                            <input type="text" id="db.user" name="db_username" placeholder="Database username" required />
                        </p>

                        <p>
                            <label for="db.password">Password</label>
                            <input type="password" id="db.password" name="db_password" placeholder="Database password" required />
                        </p>

                        <p>
                            <label for="db.name">Name</label>
                            <input type="text" id="db.name" name="db_name" placeholder="Database name" required />
                        </p>

                        <p>
                            <label for="db.host">Server</label>
                            <input type="text" id="db.host" name="db_host" placeholder="Database server" value="localhost" required />
                        </p>
                    </fieldset>
                <?php endif ?>

                <fieldset>
                    <legend>Site Details</legend>
                    <p>Enter the name of your new website and an admin email address here.</p>
                    <p>The admin email address will be used as the from email address for emails sent from BoomCMS such as to send a password when users are added to the CMS.</p>

                    <p>
                        <label for="site.name">Website Name</label>
                        <input type="text" id="site.name" name='site_name' placeholder="My awesome website" required />
                    </p>

                    <p>
                        <label for="site.email">Admin email</label>
                        <input type="text" id="site.email" name='site_email' placeholder="admin@email.com" required />
                    </p>
                </fieldset>

                <fieldset>
                    <legend>CMS Admin Details</legend>
                    <p>Enter than name and email address of the CMS admin user here, that's probably you.</p>
                    <p>This person will have full access to the CMS to create pages and grant CMS access to other people.</p>

                    <p>
                        <label for="user.name">Full name</label>
                        <input type="text" id="user.name" name='user_name' placeholder="Firstname Lastname" required />
                    </p>

                    <p>
                        <label for="user.email">Email address</label>
                        <input type="text" id="user.email" name='user_email' placeholder="name@email.com" required />
                    </p>
                </fieldset>

                <input type="submit" value="Install Boom" />
            </form>
        </main>
    </body>
</html>
