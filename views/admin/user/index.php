<?php require ROOT . '/views/layouts/header.php'; ?>

<div class="grid-content">
    <div class="main__content">
        <div class="row main-padding">
            <div class="col create-form">
                <form class="common-ajax-form nice-form form-add" action="/admin/user/create" method="POST">
                    <div class="main__content-input">
                        <select name="role">
                            <option value="0">Роль</option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?php print $role['id'] ?>">
                                    <?php print $role['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Логин" type="text" name="login" value="">
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Имя" type="text" name="name" value="">
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Фамилия" type="text" name="surname" value="">
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Отчество" type="text" name="patronymic" value="">
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Телефон" type="text" name="phone" value="">
                    </div>
                    <div class="main__content-input">
                        <input placeholder="Пароль" type="password" name="password" value="">
                    </div>
                    <button class="btn-default" type="submit">Создать</button>
                </form>
            </div>
            <div class="col table">
                <table>
                    <thead>
                        <th>Роль</th>
                        <th>Логин</th>
                        <th>Имя</th>
                        <th>Фамилия</th>
                        <th>Отчество</th>
                        <th>Телефон</th>
                        <th>Пароль</th>
                        <th>Действия</th>
                    </thead>
                    <tbody>
                        <?php foreach($users as $user): ?>
                            <tr data-id="<?php print $user['id']; ?>" data-action="/admin/user/update">

                                <td class="editable">
                                    <span><?php print $user['role']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <div class="main__content-input">
                                            <select name="role">
                                                <?php foreach($roles as $role): ?>
                                                    <option
                                                        <?php $user['role'] == $role['id'] ? print 'selected' : '' ?>
                                                        value="<?php print $role['id'] ?>">
                                                        <?php print $role['name'] ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </form>
                                </td>

                                <td class="editable">
                                    <span><?php print $user['login']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="text" name="login" value="<?php print $user['login']; ?>">
                                    </form>
                                </td>

                                <td class="editable">
                                    <span><?php print $user['name']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="text" name="name" value="<?php print $user['name']; ?>">
                                    </form>
                                </td>

                                <td class="editable">
                                    <span><?php print $user['surname']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="text" name="surname" value="<?php print $user['surname']; ?>">
                                    </form>
                                </td>

                                <td class="editable">
                                    <span><?php print $user['patronymic']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="text" name="patronymic" value="<?php print $user['patronymic']; ?>">
                                    </form>
                                </td>

                                <td class="editable">
                                    <span><?php print $user['phone']; ?></span>
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="text" name="phone" value="<?php print $user['phone']; ?>">
                                    </form>
                                </td>

                                <td class="editable">
                                    <form class="common-ajax-form nice-form" action="" method="POST">
                                        <input type="password" name="password" value="">
                                    </form>
                                </td>

                                <td class="actions">
                                    <div class="col">
                                        <button class="btn-icon gray form-edit" type="button">
                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        </button>
                                        <button class="btn-icon hidden green form-save">
                                            <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    <div class="col">
                                        <form class="common-ajax-form form-delete" action="/admin/user/delete" method="POST">
                                            <input type="hidden" name="id" value="<?php print $user['id']; ?>">
                                            <button class="btn-icon gray" type="submit">
                                                <i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>

                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        

        <?php 
            // Раскомментировать, когда появиться js для пагинации
            // if ($total > 20) {
            //  print $this->paginator->get();
            // }
        ?>
    </div>
</div>
<?php require ROOT . '/views/layouts/footer.php'; ?>