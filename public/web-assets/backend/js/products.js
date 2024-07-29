$(document).ready(function () {
    is_for_browse_file = true;
    filtermedia();
    $("#short_description").summernote({
        tabsize: 2,
        height: 200,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["view", ["fullscreen", "help"]],
        ],
    });
    $("#description").summernote({
        tabsize: 2,
        height: 200,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link", "picture"]],
            ["view", ["fullscreen", "help"]],
        ],
        callbacks: {
            onImageUpload: function (images, editor, welEditable,) {
                sendFile(images[0], editor, welEditable, 'description');
            }
        }
    });

    /*Generate permalink*/
    $(".product_name").change(function (e) {
        e.preventDefault();
        let name = $(".product_name").val();
        let permalink = string_to_slug(name);
        $("#permalink").html(permalink);
        $("#permalink_input_field").val(permalink);
        $(".permalink-input-group").removeClass("d-none");
        $(".permalink-editor").addClass("d-none");
        $(".permalink-edit-btn").removeClass("d-none");
    });
    /*edit permalink*/
    $(".permalink-edit-btn").on("click", function (e) {
        e.preventDefault();
        let permalink = $("#permalink").html();
        $("#permalink-updated-input").val(permalink);
        $(".permalink-edit-btn").addClass("d-none");
        $(".permalink-editor").removeClass("d-none");
    });
    /*Cancel permalink edit*/
    $(".permalink-cancel-btn").on("click", function (e) {
        e.preventDefault();
        $("#permalink-updated-input").val();
        $(".permalink-editor").addClass("d-none");
        $(".permalink-edit-btn").removeClass("d-none");
    });
    /*Update permalink*/
    $(".permalink-save-btn").on("click", function (e) {
        e.preventDefault();
        let input = $("#permalink-updated-input").val();
        let updated_permalink = string_to_slug(input);
        $("#permalink_input_field").val(updated_permalink);
        $("#permalink").html(updated_permalink);
        $(".permalink-editor").addClass("d-none");
        $(".permalink-edit-btn").removeClass("d-none");
    });
});
/**
 * Select product type
 */
function switchProductType(type = "single") {
    $('.product-gallery-images').removeClass('d-none');
    if (type == "variant") {
        $(".product-variation").removeClass("d-none");
        $(".variant-product-price").removeClass("d-none");
        $(".single-product-price").addClass("d-none");
        $(".select2-container--classic").css("width", "100%");
    } else {
        $(".product-variation").addClass("d-none");
        $(".variant-product-price").addClass("d-none");
        $(".single-product-price").removeClass("d-none");
        $(".product-color-images").addClass('d-none');
    }
}

/**
 * Select product shipping areas
 */
function switchProductShippingArea() { }
