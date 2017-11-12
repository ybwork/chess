<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content admin__panel">
    <div class="main__content">
        <form class="admin__add-user-body common-ajax-form" action="/admin/user/create" method="POST">
            <div class="main__content-input">
                <label>Роль:</label>
                <select name="role">
                    <option value="0"></option>
                    <?php foreach($roles as $role): ?>
                        <option value="<?php print $role['id'] ?>">
                            <?php print $role['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="main__content-input">
                <label>Логин:</label>
                <input type="text" name="login" value="">
            </div>

            <div class="main__content-input">
                <label>Имя:</label>
                <input type="text" name="name" value="">
            </div>

            <div class="main__content-input">
                <label>Фамилия:</label>
                <input type="text" name="surname" value="">
            </div>
           
            <div class="main__content-input">
                <label>Отчество:</label>
                <input type="text" name="patronymic" value="">
            </div>

            <div class="main__content-input">
                <label>Телефон:</label>
                <input type="text" name="phone" value="">
            </div>

            <div class="main__content-input">
                <label>Пароль:</label>
                <input type="password" name="password" value="">
            </div>
        
            <div class="main__content-button align-right">
                <button type="submit">Создать</button>
            </div>
        </form>

        <table class="admin__table" width="100%" border="0" cellspacing="0">
            <tbody>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td>
                            <div class="admin__table-name">
                                <?php print $user['surname']?>
                                    <?php print $user['name']?>
                                        <?php print $user['patronymic']?>
                            </div>
                            <div class="admin__table-role">
                                <?php print $user['role']?>
                            </div>
                        </td>

                        <td>
                            <!-- Пока не появиться js -->
                            <form class="common-ajax-form" action="/admin/user/edit/<?php print $user['id'] ?>" method="GET">
                                <button>Редактировать</button>
                            </form>
                            <!-- Пока не появиться js -->

                            <form class="common-ajax-form" action="/admin/user/delete" method="POST">
                                <input type="hidden" name="id" value="<?php print $user['id'] ?>">
                                <button type="submit">Удалить</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Пока не появиться js -->
                    <form class="common-ajax-form" action="/admin/user/update" method="POST">
                        <input type="hidden" name="id" value="<?php print $user['id']; ?>">
                        <label>Логин:</label>
                        <input type="text" name="login" value="<?php print $user['login']; ?>">
                        <label>Пароль:</label>
                        <input type="password" name="password" value="">
                        <label>Роль:</label>
                        <select name="role">
                            <option value="0"></option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?php print $role['id'] ?>">
                                    <?php print $role['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label>Фамилия:</label>
                        <input type="text" name="surname" value="<?php print $user['surname']; ?>">
                        <label>Телефон:</label>
                        <input type="text" name="phone" value="<?php print $user['phone']; ?>">
                        <label>Имя:</label>
                        <input type="text" name="name" value="<?php print $user['name']; ?>">
                        <label>Отчество:</label>
                        <input type="text" name="patronymic" value="<?php print $user['patronymic']; ?>">
                        <button type="submit">Обновить</button>
                    </form>
                    <br>
                    <br>
                    <br>
                    <br>
                    <!-- Пока не появиться js -->

                <?php endforeach; ?>
            </tbody>
        </table>

        <?php if($total > 2): ?>
            <?php print $this->paginator->get(); ?>
        <?php endif; ?>
    </div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>