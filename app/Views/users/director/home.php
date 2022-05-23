<h1>Direktoriaus aplinka (<a href="<?= base_url('/home/logout') ?>">Atsijungti</a>)</h1>

<hr>

<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>
<? if (isset($success)) { ?>
    <?= $success ?>
<? } ?>

<ul>
    <li>
        <a href="<?= base_url('/director/teachers') ?>">Mokytojai</a>
    </li>
    <li>
        <a href="<?= base_url('/director/lessons') ?>">Pamokos</a>
    </li>
    <li>
        <a href="<?= base_url('/director/classes') ?>">Klases</a>
    </li>
    <li>
        <a href="<?= base_url('/director/students') ?>">Mokiniai</a>
    </li>
</ul>