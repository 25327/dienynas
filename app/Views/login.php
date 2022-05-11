<? if (isset($errors)) { ?>
    <?= $errors ?>
<? } ?>

<form action="<?= base_url('home/login') ?>" method="post">
    Email: <input type="text" name="name"><br>
    Password: <input type="text" name="password"><br>
    <input type="submit" value="Prisijungti">
</form>