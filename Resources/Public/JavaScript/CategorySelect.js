$('.tx-bw-gallery .header .categories .category').on("click", function() {
    const categoryUid = $(this).attr("data-category");

    // Buttons anpassen
    $(this).closest('.categories').find('.category.btn-primary').removeClass("btn-primary").addClass("btn-secondary");
    $(this).removeClass("btn-secondary").addClass("btn-primary");

    // Bilder anzeigen
    $(this).closest('.gallerycontainer').find('.gallery .image').each(function() {
        console.log(categoryUid);
        if(categoryUid < 0) {
            $(this).show();
        } else {
            const imageCategories = $(this).attr("data-categories").split(",");
            if(imageCategories.includes(categoryUid)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        }
    });
    return false;
});

console.log("init lazy loading!");
var lazyLoadInstance = new LazyLoad({
    // Your custom settings go here
});