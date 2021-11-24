<?php

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

?>
<h2>Список доменов</h2>
<form name="domainForm">
  <input type="hidden" name="id" value="0" />
  <div class="form-group">
    <label for="name">Домен:</label>
    <input class="form-control" name="name" />
  </div>
  <!-- <div class="form-group">
            <label for="age">Возраст:</label>
            <input class="form-control" name="age" />
        </div> -->
  <div class="panel-body">
    <?= Html::a(
      'Text',
      [Url::to('http://localhost:3000/api/domains', true)],
      [
        'data-method' => 'POST',
        'data-params' => [
          'csrf_param' => \Yii::$app->request->csrfParam,
          'csrf_token' => \Yii::$app->request->csrfToken,
          ''
        ],
      ]
    ) ?>
    <button type="submit" class="btn btn-sm btn-primary">Сохранить</button>
    <a id="reset" class="btn btn-sm btn-primary">Сбросить</a>
  </div>
</form>
<table class="table table-condensed table-striped table-bordered">
  <thead>
    <tr>
      <th>Id</th>
      <th>Домен</th>
      <!-- <th>возраст</th> -->
      <th></th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>

<?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>
                <?php echo $form->field($model, 'domain')->textInput(['maxlength' => true]) ?>
<?php ActiveForm::end(); ?>

<?php
$this->registerJs('
async function CreateDomain(domainName) {
  const response = await fetch("http://localhost:3000/api/domains", {
    method: "POST",
    headers: {
      "Accept": "application/json",
      "Content-Type": "application/json"
    },
    body: JSON.stringify({
      name: ,
    })
  });
  if (response.ok === true) {
    const domain = await response.json();
    reset();
    document.querySelector("tbody").append(row(domain));
  }
}
  ',
  \yii\web\View::POS_READY
);
?>


<script>
  // Получение всех доменов
  // async function GetDomains() {
  //   // отправляет запрос и получаем ответ
  //   const response = await fetch("http://localhost:3000/api/domains", {
  //     method: "GET",
  //     headers: {
  //       "Accept": "application/json",
  //     }
  //   });
  //   // если запрос прошел нормально
  //   if (response.ok === true) {
  //     // получаем данные
  //     const domain = await response.json();
  //     let rows = document.querySelector("tbody");
  //     domain.forEach(domain => {
  //       // добавляем полученные элементы в таблицу
  //       rows.append(row(domain));
  //     });
  //   }
  // }
  // Получение одного пользователя
  async function GetDomain(id) {
    const response = await fetch("http://localhost:3000/api/domains/" + id, {
      method: "GET",
      headers: {
        "Accept": "application/json"
      }
    });
    if (response.ok === true) {
      const domain = await response.json();
      const form = document.forms["domainForm"];
      form.elements["id"].value = domain.id;
      form.elements["name"].value = domain.name;
      // form.elements["age"].value = user.age;
    }
  }
  // Добавление пользователя
  async function CreateDomain(domainName) {
    const response = await fetch("http://localhost:3000/api/domains", {
      method: "POST",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        name: domainName,
        // age: parseInt(userAge, 10)
      })
    });
    if (response.ok === true) {
      const domain = await response.json();
      reset();
      document.querySelector("tbody").append(row(domain));
    }
  }
  // Изменение пользователя
  async function EditDomain(domainId, domainName) {
    const response = await fetch("http://localhost:3000/api/domains", {
      method: "PUT",
      headers: {
        "Accept": "application/json",
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        id: domainId,
        name: domainName,
        // age: parseInt(userAge, 10)
      })
    });
    if (response.ok === true) {
      const domain = await response.json();
      reset();
      document.querySelector("tr[data-rowid='" + domain.id + "']").replaceWith(row(domain));
    }
  }
  // Удаление пользователя
  async function DeleteDomain(id) {
    const response = await fetch("http://localhost:3000/api/domains/" + id, {
      method: "DELETE",
      headers: {
        "Accept": "application/json"
      }
    });
    if (response.ok === true) {
      const domain = await response.json();
      document.querySelector("tr[data-rowid='" + domain.id + "']").remove();
    }
  }

  // сброс формы
  function reset() {
    const form = document.forms["domainForm"];
    form.reset();
    form.elements["id"].value = 0;
  }
  // создание строки для таблицы
  function row(domain) {
    const tr = document.createElement("tr");
    tr.setAttribute("data-rowid", domain.id);

    const idTd = document.createElement("td");
    idTd.append(domain.id);
    tr.append(idTd);

    const nameTd = document.createElement("td");
    nameTd.append(domain.name);
    tr.append(nameTd);

    // const ageTd = document.createElement("td");
    // ageTd.append(user.age);
    // tr.append(ageTd);
    const linksTd = document.createElement("td");
    const editLink = document.createElement("a");
    editLink.setAttribute("data-id", domain.id);
    editLink.setAttribute("style", "cursor:pointer;padding:15px;");
    editLink.append("Изменить");
    editLink.addEventListener("click", e => {
      e.preventDefault();
      GetDomain(domain.id);
    });
    linksTd.append(editLink);
    const removeLink = document.createElement("a");
    removeLink.setAttribute("data-id", domain.id);
    removeLink.setAttribute("style", "cursor:pointer;padding:15px;");
    removeLink.append("Удалить");
    removeLink.addEventListener("click", e => {
      e.preventDefault();
      DeleteDomain(domain.id);
    });
    linksTd.append(removeLink);
    tr.appendChild(linksTd);

    return tr;
  }
  // сброс значений формы
  document.getElementById("reset").click(function(e) {
    e.preventDefault();
    reset();
  })

  // отправка формы
  document.forms["domainForm"].addEventListener("submit", e => {
    e.preventDefault();
    const form = document.forms["domainForm"];
    const id = form.elements["id"].value;
    const name = form.elements["name"].value;
    // const age = form.elements["age"].value;
    if (id == 0)
      CreateDomain(name);
    else
      EditDomain(id, name);
  });

  // загрузка пользователей
</script>