<!-- Static navbar -->
<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand brand-logo" href="<?= URL::route('home') ?>">
                <img alt="Brand" src="<?= URL::asset('/img/SIF-logo-u-baggrund.png') ?>" height="60px">
            </a>
            <a class="navbar-brand" href="<?= URL::route('home') ?>">
                <span class="pull-left">SIF Quiz Manager</span>
            </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?= URL::route('home') ?>">Home</a>
                </li>

            </ul>

            <?php if(Auth::check()): ?>
                <p class="navbar-text navbar-right">
                    Signed in as <strong><?= Auth::user()->username; ?></strong>
                    (<a href="<?=URL::route('auth.logout'); ?>" class="navbar-link">Logout</a>)
                </p>
            <?php endif; ?>

        </div>
    </div>
</div>