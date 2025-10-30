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


    const swiperGridElement = document.querySelector('.mySwiperGridEnded');
    if(swiperGridElement){
        const totalSlides = swiperGridElement.querySelectorAll('.swiper-slide').length;
        const numRows = totalSlides <= 4 ? 1 : 2;
        const swiper = new Swiper(".mySwiperGridEnded", {
            slidesPerView: 3,
            
            grid: {
                rows: numRows,
            },
            spaceBetween: 30,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".mySwiperGridEnded .swiper-button-next", 
                prevEl: ".mySwiperGridEnded .swiper-button-prev",
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