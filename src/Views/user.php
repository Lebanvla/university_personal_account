<div>
    Пользователь:
    <p>
        <?= "$family $name $patronymic" ?>
    </p>
    Группа:
    <p>
        <?= $group_id ?>
    </p>

    <p>:
        <button onclick="getStudyPlan(<?= $id ?>)">Получить учебный план</button>
    </p>


</div>

<script>
    function getStudyPlan(id) {
        table = ''
        '<table><thead></thead>>'
        'asdsd'
        '';
        fetch(`http://localhost/student_plan`)
            .then(response => response.json())
            .then(data => {
                console.log(data.study_plan)
            })
            .catch(error => {
                alert("Возникла ошибка");
            });
    }
</script>