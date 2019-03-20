<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-header">
        Payments
    </div>
    <div class="card-body">
        <div class="alert alert-success d-none" role="alert" id="dataAlert"></div>
        <table class="table table-bordered table-hover" id="dataTable">
            <thead>
                <tr>
                    <th scope="col">Payment</th>
                    <th scope="col">Description</th>
                    <th scope="col" width="200">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="btn btn-success" onclick="add();"><i class="fas fa-plus"></i> Add Payment</button>
    </div>
</div>

<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger d-none" role="alert" id="formAlert">
                    <ul class="m-0"></ul>
                </div>
                <form method="post">
                    <input type="hidden" id="pay_id" name="pay_id" value="">
                    <div class="form-group">
                        <label for="pay_name">Payment</label>
                        <input type="text" class="form-control" id="pay_name" name="pay_name" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="pay_description">Description</label>
                        <input type="text" class="form-control" id="pay_description" name="pay_description" value="" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
                <button type="button" class="btn btn-primary" onclick="save();"><i class="fas fa-check"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        show();
    });

    function show() {
        $.post("pages/payments-service.php", function (result) {
            var row = "";

            $.each(result.data, function (index, value) {
                row += '<tr> \
                    <td>' + value.pay_name + '</td> \
                    <td>' + value.pay_description + '</td> \
                    <td> \
                        <button type="button" class="btn btn-primary btn-sm mr-1" onclick="edit(' + value.pay_id + ');"><i class="fas fa-pen"></i> Edit</button> \
                        <button type="button" class="btn btn-danger btn-sm" onclick="drop(' + value.pay_id + ');"><i class="fas fa-trash"></i> Delete</button> \
                    </td> \
                </tr>';
            });

            $("#dataTable tbody").empty().append(row);
        }, "json");
    }

    function add() {
        $("#pay_id").val("");
        $("#pay_name").val("");
        $("#pay_description").val("");

        $("#formAlert").addClass("d-none");
        $("#formModalLabel").text("Add Payment");
        $("#formModal").modal("show");
    }

    function edit(id) {
        if (typeof id !== "undefined") {
            $.post("pages/payments-service.php", {pay_id: id}, function (result) {
                $("#pay_id").val(result.data.pay_id);
                $("#pay_name").val(result.data.pay_name);
                $("#pay_description").val(result.data.pay_description);

                $("#formAlert").addClass("d-none");
                $("#formModalLabel").text("Edit Payment");
                $("#formModal").modal("show");
            }, "json");
        }
    }

    function save() {
        var data = {
            pay_id: $("#pay_id").val(),
            pay_name: $("#pay_name").val(),
            pay_description: $("#pay_description").val(),
            action: ($("#pay_id").val() != "" ? "update" : "create")
        };

        $.post("pages/payments-service.php", data, function (result) {
            if (result.status == "success") {
                $("#dataAlert").text(result.message);
                $("#dataAlert").removeClass("d-none");

                $("#formModal").modal("hide");

                show();
            } else {
                var list = "";

                $.each(result.message, function (index, value) {
                    list += '<li>' + value + '</li>';
                });

                $("#formAlert ul").empty().append(list);
                $("#formAlert").removeClass("d-none");
            }
        }, "json");
    }

    function drop(id) {
        if (typeof id !== "undefined") {
            if (confirm("Are you sure to delete?") == true) {
                $.post("pages/payments-service.php", {action: "delete", pay_id: id}, function (result) {
                    if (result.status == "success") {
                        $("#dataAlert").text(result.message);
                        $("#dataAlert").removeClass("d-none");

                        show();
                    }
                }, "json");
            }
        }
    }
</script>