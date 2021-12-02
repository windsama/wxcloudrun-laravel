<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <link
      rel="shortcut icon"
      href="https://static-index-4gtuqm3bfa95c963-1304825656.tcloudbaseapp.com/official-website/favicon.svg"
      mce_href="https://static-index-4gtuqm3bfa95c963-1304825656.tcloudbaseapp.com/official-website/favicon.svg"
      type="image/x-icon"
    />
    <meta name="viewport" content="width=650,user-scalable=no" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
      crossorigin="anonymous"
    />
    <title>欢迎使用微信云托管</title>
    <style>
      .title-logo {
        height: 80px;
      }
      .container {
        margin-top: 100px;
      }
      .count-button {
        margin: 20px 0;
        margin: 10px;
      }
      .count-number {
        font-size: 28px;
        font-weight: bolder;
        margin: 0 8px;
      }
      .count-text {
        margin-bottom: 80px;
      }
      .quote {
        font-size: 12px;
      }
      .qrcode {
        height: 180px;
        display: block;
        margin: 0 auto;
      }
      .title {
        display: flex;
        align-items: center;
        justify-content: center;
      }
    </style>
  </head>

  <body>
    <div class="container">
      <div class="title">
        <img
          class="title-logo"
          src="https://static-index-4gtuqm3bfa95c963-1304825656.tcloudbaseapp.com/official-website/favicon.svg"
        />
        <h1 style="display: inline">欢迎使用微信云托管</h1>
      </div>
      <div style="text-align: center">
        <div style="display: flex; justify-content: center">
          <a class="btn btn-success btn-lg count-button" onclick="set('inc')"
            >计数+1</a
          >
          <a
            class="btn btn-outline-success btn-lg count-button"
            onclick="set('clear')"
            >清零</a
          >
        </div>
        <p class="count-text">当前计数：<span class="count-number"></span></p>
        <img
          class="qrcode middle"
          src="https://qcloudimg.tencent-cloud.cn/raw/89b46988d3cd73d8a56e76a1b82bb377.png"
        />
        <small class="text-black-50">扫码加入微信云托管用户群</small>
      </div>
    </div>
  </body>
  <script src="https://mat1.gtimg.com/www/asset/lib/jquery/jquery/jquery-1.11.1.min.js"></script>
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"
  ></script>
  <script>
    init();
    function init() {
      $.ajax("/api/count", {
        method: "get",
      }).done(function (res) {
        if (res && res.data !== undefined) {
          $(".count-number").html(res.data);
        }
      });
    }
    function set(action) {
      $.ajax("/api/count", {
        method: "POST",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        data: JSON.stringify({
          action: action,
        }),
      }).done(function (res) {
        if (res && res.data !== undefined) {
          $(".count-number").html(res.data);
        }
      });
    }
  </script>
</html>
