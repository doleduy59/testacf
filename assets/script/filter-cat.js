

let selectionCat = 0;

function categoryFilter() {
    const filterBtn = document.querySelectorAll('.category-btn-filter');

    filterBtn.forEach(btn => {
        btn.addEventListener('click', (e) => {
            const clickedBtn = e.currentTarget;
            const catId = clickedBtn.getAttribute('data-cat-id');


            selectionCat = parseInt(catId, 10);
            console.log('Đã gán selectionCat =', selectionCat);


            filterBtn.forEach(b => b.classList.remove('active'));
            clickedBtn.classList.add('active');


            jQuery.post(my_ajax.url, {
                _ajax_nonce: my_ajax.nonce, // bảo mật, chưa hiểu rõ
                action: "load_category_posts", // nhận biết action
                cat_id: selectionCat  // Gửi biến vừa gán
            }, function (response) {
                if (response.success) {
                    document.querySelector('.catList .posts-list').outerHTML = response.data;
                    console.log('Đã load bài viết thành công!');
                    console.log('Biến selectionCat hiện tại:', selectionCat);
                }
            }).fail(function () {
                console.error('Lỗi AJAX');
            });
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    categoryFilter();
});
