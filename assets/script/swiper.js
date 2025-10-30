document.addEventListener('DOMContentLoaded', function() {
    const swiperElement = document.querySelector('.mySwiper');
    if (swiperElement) {
        const swiper = new Swiper(".mySwiper", {
            loop: true,
            navigation: {
                nextEl: ".mySwiper .swiper-button-next", 
                prevEl: ".mySwiper .swiper-button-prev",
            },
        });
    }


    const swiperGridElement = document.querySelector('.mySwiperGrid');
    if(swiperGridElement){
        const swiper = new Swiper(".mySwiperGrid", {
            slidesPerView: 3,
            grid: {
                rows: 2,
            },
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".mySwiperGrid .swiper-button-next", 
                prevEl: ".mySwiperGrid .swiper-button-prev",
            },
        });
    }



    const swiperGridElementSoon = document.querySelector('.mySwiperGridSoon');
    if(swiperGridElementSoon){
        const swiper = new Swiper(".mySwiperGridSoon", {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
                        navigation: {
                nextEl: ".mySwiperGridSoon .swiper-button-next", 
                prevEl: ".mySwiperGridSoon .swiper-button-prev",
            },
        });
    }
});