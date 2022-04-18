$(function () {
    // global states
    const PRODUCT_STATE = {
        id: null,
        article: null,
        name: null,
        status: null,
        attributes: [],
    };

    $("tr.single-product").on("click", function () {
        PRODUCT_STATE.id = $(this).data("productid");

        $.ajax({
            url: `/products/${PRODUCT_STATE.id}`,
            method: "GET",
            success: function (response) {
                PRODUCT_STATE.article = response.product.article;
                PRODUCT_STATE.name = response.product.name;
                PRODUCT_STATE.status = response.product.status;
                PRODUCT_STATE.attributes = response.product.data;

                $("div.product-create-dialog").addClass("hide");
                $("div.product-view-dialog").removeClass("hide");

                $("div.product-view-dialog div.modal-header h4").text(
                    PRODUCT_STATE.name
                );

                $(
                    "div.product-view-dialog div.modal-header span.remove-product a"
                ).attr("href", `/products/${PRODUCT_STATE.id}/delete`);

                $("div.product-view-dialog div.modal-body div.article").html(
                    `<div class='col-sm-3'>Артикул:</div> <div class='col'>${PRODUCT_STATE.article}</div>`
                );
                $("div.product-view-dialog div.modal-body div.name").html(
                    `<div class='col-sm-3'>Название:</div> <div class='col'>${PRODUCT_STATE.name}</div>`
                );
                $("div.product-view-dialog div.modal-body div.status").html(
                    `<div class='col-sm-3'>Статус:</div> <div class='col'>${PRODUCT_STATE.status}</div>`
                );

                $(
                    "div.product-view-dialog div.modal-body div.attributes"
                ).empty();
                $(
                    "div.product-view-dialog div.modal-body div.attributes"
                ).append(`<div class='col-sm-3'>Атрибуты: </div>`);
                JSON.parse(PRODUCT_STATE.attributes).map((item, index) => {
                    $(
                        "div.product-view-dialog div.modal-body div.attributes"
                    ).append(
                        `<div class='col'>${item.name}: ${item.value}</div> <br/>`
                    );
                });
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    $("span.open-edit-dialog").on("click", function () {
        $("div.product-view-dialog").addClass("hide");
        $("div.product-edit-dialog").removeClass("hide");

        $("div.product-edit-dialog div.modal-body form").attr(
            "action",
            `/products/${PRODUCT_STATE.id}/edit`
        );

        $("div.product-edit-dialog div.modal-header h4").text(
            PRODUCT_STATE.name
        );

        $("div.product-edit-dialog div.modal-body input[name='article']").val(
            PRODUCT_STATE.article
        );

        $("div.product-edit-dialog div.modal-body input[name='name']").val(
            PRODUCT_STATE.name
        );

        $("div.product-edit-dialog div.modal-body select[name='status']").val(
            PRODUCT_STATE.status
        );

        JSON.parse(PRODUCT_STATE.attributes).map((item, index) => {
            $(
                "div.product-edit-dialog div.modal-body div.product-attributes"
            ).append(
                `<div class="form-group mt-2">
                    <div class='row'>
                        <div class='col-5'>
                            <label for="attr_name">Название</label>
                            <input type="text" class="form-control" id="attr_name" name="attr_name[]" value='${item.name}'>
                        </div>
                        <div class='col-5'>
                            <label for="attr_value">Значение</label>
                            <input type="text" class="form-control" id="attr_value" name="attr_value[]" value='${item.value}'>
                        </div>
                        <div class='col-2 d-flex align-items-center'>
                            <span class='remove-product-attr' title='Удалить'>
                                <i class='fas fa-trash-alt'></i>
                            <span>
                        </div>
                    </div>
                </div>`
            );
        });
    });

    $("button#open-create-dialog").on("click", function () {
        $("div.product-create-dialog").removeClass("hide");
    });

    $("div.product-create-dialog span.product-add-attribute").on(
        "click",
        function () {
            let content = `<div class="form-group mt-2">
                            <div class='row'>
                                <div class='col-5'>
                                    <label for="attr_name">Название</label>
                                    <input type="text" class="form-control" id="attr_name" name="attr_name[]">
                                </div>
                                <div class='col-5'>
                                    <label for="attr_value">Значение</label>
                                    <input type="text" class="form-control" id="attr_value" name="attr_value[]">
                                </div>
                                <div class='col-2 d-flex align-items-center'>
                                    <span class='remove-product-attr' title='Удалить'>
                                        <i class='fas fa-trash-alt'></i>
                                    <span>
                                </div>
                            </div>
                        </div>`;

            $("div.product-create-dialog div.product-attributes").append(
                content
            );
        }
    );

    $("div.product-edit-dialog span.product-add-attribute").on(
        "click",
        function () {
            let content = `<div class="form-group mt-2">
                            <div class='row'>
                                <div class='col-5'>
                                    <label for="attr_name">Название</label>
                                    <input type="text" class="form-control" id="attr_name" name="attr_name[]">
                                </div>
                                <div class='col-5'>
                                    <label for="attr_value">Значение</label>
                                    <input type="text" class="form-control" id="attr_value" name="attr_value[]">
                                </div>
                                <div class='col-2 d-flex align-items-center'>
                                    <span class='remove-product-attr' title='Удалить'>
                                        <i class='fas fa-trash-alt'></i>
                                    <span>
                                </div>
                            </div>
                        </div>`;

            $("div.product-edit-dialog div.product-attributes").append(content);
        }
    );

    $(document).on("click", ".remove-product-attr", function () {
        $(this).parent().parent().remove();
    });

    // close modal
    $("span.close-modal").on("click", function () {
        $(this).parent().parent().addClass("hide");
    });
});
