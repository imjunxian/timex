<?php
include('navbar_user.php');
?>
<div class="loader"></div>

<style type="text/css">
  .loader{
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  background: url('../../dist/img/806.gif')
              50% 50% no-repeat rgb(249,249,249);
}

body.modal-open-noscroll
{
  margin-right: 0!important;
  overflow: hidden;
}
.modal-open-noscroll .navbar-fixed-top, .modal-open .navbar-fixed-bottom
{
  margin-right: 0!important;
}
body.modal-open-noscroll
{
  margin-right: 0!important;
  overflow: hidden;
}
.modal-open-noscroll .navbar-default, .modal-open .navbar-default
{
  margin-right: 0!important;
}

.img-thumbnail{
  padding: 0.25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: 0.25rem;
  max-width: 100%;
  height: auto;
  width: 70px;
  height: 70px;
  object-fit: fill;
}

.img-thumbnail-table{
  padding: 0.25rem;
  background-color: #fff;
  border: 1px solid #dee2e6;
  border-radius: 0.25rem;
  height: auto;
  width: 100px;
  height: 100px;
  object-fit: fill;
}

.img-prod-detail{
  border-radius: 8px;
  background-color: #ebebeb;
  width: 400px;
  height: 400px;
  cursor: pointer;
  transition: .3s ease-in-out;
}

</style>

<script type="text/javascript">
//loader while loading
document.onreadystatechange = function () {
  if(document.readyState !== "complete") {
    document.querySelector("body").style.visibility = "hidden";
    document.querySelector(".loader").style.visibility = "visible";
  }else{
    document.querySelector(".loader").style.display = "none";
    document.querySelector("body").style.visibility = "visible";
  }
};
</script>