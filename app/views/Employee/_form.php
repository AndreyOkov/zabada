

<?php if ($type === 'create') : ?>
    <h1>Создание сотрудника</h1>
<?php else : ?>
    <h1>Обновиление данных о сотруднике</h1>
<?php endif; ?>
<form id="myForm" action="/employee/update?type=<?= $type ?>" method='post' class="well form-horizontal">
    <div class="form-group">
        <label class="control-label col-sm-2" for="firstname">Фамилия:</label>
        <div class="col-sm-10">
            <input id="fn" type="text" name="firstname" value="<?= field($formData, 'firstname') ?>"/>
            <div class="error-container"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Имя:</label>
        <div class="col-sm-10">
            <input id="ln" type="text" name="lastname" value="<?= field($formData, 'lastname') ?>"/>
            <div class="error-container"></div>

        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Отчество:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="patronymic" value="<?= field($formData, 'patronymic') ?>"/>
            <div class="error-container"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">Пол:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="gender" value="<?= field($formData, 'gender') ?>"/>
            <div class="error-container"></div>
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-sm-2" for="lastname">З/п:</label>
        <div class="col-sm-10">
            <input id="" type="text" name="salary" value="<?= field($formData, 'salary') ?>"/>
            <div class="error-container"></div>
        </div>
    </div>
        <input type="hidden" name="id" value="<?=field($formData, 'id')?> "/>

    <div class="form-group">
        <div class="col-sm-10">
            <label class="control-label col-sm-2" for="lastname">Отделы:</label>
            <select class="chosen" multiple="true" name="departments[]">
                <?php optionHelper($allDepartments, $employeeDepartments); ?>
            </select>
        </div>
    </div>
    <p><input type="submit" value="<?php echo($type === 'create' ? 'create' : 'update') ?>"/></p>
</form>

<script>
     $("input[type='submit']").on("click",function (e) {
         e.preventDefault();
         var form = $("#myForm");
         var formData = formDataToArray(form);
         $.post("/employee/ajax", {formData :formData}, function(data){
             if(data[0] === false){
                 handleAjax(data, form, '.error-container');
             } else {
                 form.submit();
             }
    },"json");
    });
</script>