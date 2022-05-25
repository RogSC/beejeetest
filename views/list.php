<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th scope="col"><a href="?sort=id&type=asc"><i class="fa fa-angle-double-up"></i></a> ID <a><i class="fa fa-angle-double-down"></i></a></th>
            <th scope="col">Имя пользователя</th>
            <th scope="col">Email</th>
            <th scope="col">Текст задачи</th>
            <th scope="col">Статус</th>
        </tr>
        </thead>
        <tbody>
            <?foreach ($tasks as $task) {?>
                <tr>
                    <td><?=$task['id']?></td>
                    <td><?=$task['userName']?></td>
                    <td><?=$task['userEmail']?></td>
                    <td><?=$task['descr']?></td>
                    <td><?=$task['status']?></td>
                </tr>
            <?}?>
        </tbody>
    </table>
</div>