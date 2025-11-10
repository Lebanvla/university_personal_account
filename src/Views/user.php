<div>
    Пользователь:
    <p>
        <?= "$family $name $patronymic" ?>
    </p>
    Группа:
    <p>
        <?= $group ?>
    </p>

    <p>:
        <button onclick="getStudyPlan(<?= $id ?>)">Получить учебный план</button>
    </p>

    <div id="study_plan"></div>
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
                document.getElementById("study_plan").innerHTML = data.study_plan
            })
            .catch(error => {
                alert("Возникла ошибка");
            });
    }
</script>