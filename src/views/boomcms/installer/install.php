<!DOCTYPE html>
<html dir="ltr" lang="en-gb" class="boom">
    <head>
        <title>Install BoomCMS</title>
        <meta name="robots" content="nofollow,noindex">
        <meta name="csrf-token" content="<?= csrf_token() ?>" />

        <link rel="stylesheet" type="text/css" href="/public/vendor/boomcms/core/cms.css" />
        <link rel="stylesheet" type="text/css" href="/public/vendor/boomcms/installer/install.css" />
    </head>
    <body>
        <header role="banner">
            <div id="logo"></div>
            <h1>Install BoomCMS</h1>

            <form>
                <fieldset>
                    <legend>Database Details</legend>

                    <p>
                        <label for="db.user">Database username</label>
                        <input type="text" id="db.user" name="db.name" placeholder="Database username" required />
                    </p>

                    <p>
                        <label for="db.password">Database password</label>
                        <input type="password" id="db.password" name="db.password" placeholder="Database password" required />
                    </p>

                    <p>
                        <label for="db.name">Database name</label>
                        <input type="text" id="db.name" name="db.name" placeholder="Database name" required />
                    </p>

                    <p>
                        <label for="db.host">Database host</label>
                        <input type="text" id="db.host" name="db.host" placeholder="Database host" value="localhost" required />
                    </p>
                </fieldset>

                <fieldset>
                    <legend>Site Details</legend>

                    <p>
                        <label for="site.name">Website Name</label>
                        <input type="text" id="site.name" placeholder="Website name" required />
                    </p>

                    <p>
                        <label for="site.email">Website admin email</label>
                        <input type="text" id="site.email" placeholder="Website admin email" required />
                    </p>
                </fieldset>

                <fieldset>
                    <legend>CMS Admin Details</legend>

                    <p>
                        <label for="user.name">Full name of the CMS admin user</label>
                        <input type="text" id="user.name" placeholder="Firstname Lastname" required />
                    </p>

                    <p>
                        <label for="user.email">Email address of the CMS admin user</label>
                        <input type="text" id="user.email" placeholder="name@domain.com" required />
                    </p>
                </fieldset>

                <input type="submit" />
            </form>
        </header>
    </body>
</html>