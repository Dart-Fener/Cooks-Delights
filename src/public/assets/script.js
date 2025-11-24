
/*------------------------HEADER BURGER MENU---------------------*/

$('#burger-menu').on('click',function(){
    if($('#mobile-nav').css('display') === 'none'){
        $('#mobile-nav').css('display','flex');
    }else{
        $('#mobile-nav').css('display','none');
    }     
});

/**
 * Questa funzione utlizza una media query, aggiungendo un evento che disabilita 
 * il mobile-nav automaticamente al di sopra degli 800px
 */

$(function() {
	function mediaSize() {
		if (window.matchMedia("(min-width: 800px)").matches) {
			$('#mobile-nav').css('display','none');
		}
	}
	mediaSize();
	window.addEventListener("resize", mediaSize, false);
});


/*-----------------------------SECTION HERO-------------------------*/


let heroImgs = ['Hero-1.jpg','Hero-2.jpg','Hero-3.jpg','Hero-4.jpg','Hero-5.jpg','Hero-6.jpg','Hero-7.jpg'];
let heroCounter = 0;

$('#hero').css('background-image',`url(assets/img/${heroImgs[heroCounter]})`);

setInterval(function(){

    if(heroCounter < heroImgs.length - 1){
        heroCounter++;
    }else{
        heroCounter = 0;
    }

    $('#hero').css('background-image',`url(assets/img/${heroImgs[heroCounter]})`);

},4000);


/*--------------------DIV FEATURED-CAROUSEL-SLIDER------------------*/


$(document).ready(function(){
    $('#featured-carousel-slider').slick({
        prevArrow: '#arrow-left',
        nextArrow: '#arrow-right',
        autoplay: true,
        autoplaySpeed: 3000,
        touchMove: false,
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 900,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true
                }
            },
            {
                breakpoint: 480,
                settings: {
                    touchMove: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true
                }
            }
        ]
    });
});

/*-------------------------------------PAGE RECIPES--------------------------------------*/

//Ajax per effettuare le query a database in background per le varie select
$(document).ready(function(){

    $('.selection').on('change', function(){

        if($('#container-list').length){
            $('div').remove('#container-list');
            $('#search').val('');
        }

        let formSelection = new FormData();
        let csrfToken = $('#selectors-form input[name="_token"]').val();

        formSelection.append('_token',csrfToken);
        formSelection.append('selCat',$('#selCat').val());
        formSelection.append('selArea',$('#selArea').val());
        formSelection.append('selTag',$('#selTag').val());

        if($('#search').val()){
            formSelection.append('wordIngr',$('#search').val());
        }

        let catSel = $('#selCat').val();
        let areaSel = $('#selArea').val();
        let tagSel = $('#selTag').val();

        $.ajax({
            
            url: '/recipes/request',
            method: 'post',
            data: formSelection,
            processData: false,
            contentType: false,

            beforeSend: function () {

                $('#loading').css('display','flex');

            },
            success: function(data) {

                if(data.message = 'success'){

                    $('#selCat option').attr('selected',function(selCatIndex,selectedCat){
                        if(selectedCat){
                            $('#selCat option').attr('selected',false)
                        }
                    });

                    $('#selArea option').attr('selected',function(selAreaIndex,selectedArea){
                        if(selectedArea){
                            $('#selArea option').attr('selected',false);
                        }
                    });

                    $('#selTag option').attr('selected',function(selTagIndex,selectedTag){
                        if(selectedTag){
                            $('#selTag option').attr('selected',false);
                        }
                    });
                    
                    $.each(data, function(rowIndex,value){              
                        switch(true){
                            case rowIndex == 'categories':
                                $('#selCat').html(value);
                                break;
                            case rowIndex == 'areas':
                                $('#selArea').html(value);
                                break;
                            case rowIndex == 'tags':
                                $('#selTag').html(value);
                                break;
                            case rowIndex == 'title':
                                $('#recipes-cards').css('display','inline-block');
                                $('#recipes-cards-title h1').html(value);
                                break;
                            case rowIndex == 'cards':                
                                $('#recipes-cards-list').html(value);
                                break;
                        }
                    });
                }else{
                    $('#recipes-cards').css('display','none'); 
                }

            },
            complete: function() {
                
                $('#selCat option[value='+ catSel+']').attr('selected',true);
                $('#selArea option[value='+ areaSel +']').attr('selected',true);
                $('#selTag option[value='+ tagSel +']').attr('selected',true);
                                
                $('#loading').css('display','none');

            },

        });
        
    });

    $('#search').on('invalid',function(){
        this.setCustomValidity('Please insert minimum one letter');
    });
    
    
    $("#search").on('input',function(event) {
        event.preventDefault();
        //If it isn't empty and not a number the value of search input and doesn't contain any spaces
        if($('#search').val().length && isNaN($('#search').val()) && !$('#search').val().includes(' ')){

            let formText = new FormData();
            let csrfToken = $('#form-search input[name="_token"]').val();

            formText.append('_token',csrfToken);
            formText.append('selCat',$('#selCat').val());
            formText.append('selArea',$('#selArea').val());
            formText.append('selTag',$('#selTag').val());
            formText.append('wordIngr',$('#search').val());

            $.ajax({
                
                url: '/recipes/request',
                method: 'post',
                data: formText,
                processData: false,
                contentType: false,

                beforeSend: function () {

                    $('#loading').css('display','flex');

                },
                success: function(data) {
                    
                    $('div').remove('#container-list');

                    switch(true){
                        case $('#search').val() && data.ingredients.length > 0:
                            $.each(data, function(ingrKey,ingredients){
                                if(ingrKey == 'ingredients'){
                                    $('#form-search').append('<div id="container-list">')
                                    $.each(ingredients,function(key,ingredient){
                                        $('#container-list').append('<div class="ingr-list">'+ ingredient +'</div>');
                                    });
                                    $('#form-search').append('</div>')
                                }
                            });
                            break;
                        case data.ingredients.length == 0:
                            $('#form-search').append('<div id="container-list">')
                            $('#container-list').append('<div id="ingr-empty">Ingredient not present</div>');
                            $('#form-search').append('</div>')
                            break;
                        case !$('#search').val():
                            $('div').remove('#container-list');
                            break;
                    }

                },
                complete: function() {

                    $('#loading').css('display','none');

                    let currentFocus = -1;

                    $('#search').on('keydown',function(event){
                        let count = $('.ingr-list').length -1;
                        switch(event.keyCode){
                            case 40: //keyup
                                currentFocus++;
                                break;
                            case 38: //keydown
                                currentFocus--;
                                break;
                            case 13: //enter
                                event.preventDefault();

                                let formSelectionText = new FormData();
                                let csrfToken = $('#form-search input[name="_token"]').val();

                                formSelectionText.append('_token',csrfToken);
                                formSelectionText.append('selCat',$('#selCat').val());
                                formSelectionText.append('selArea',$('#selArea').val());
                                formSelectionText.append('selTag',$('#selTag').val());
                                formSelectionText.append('wordIngr',$('.active').text());

                                let searchIngr = $('.active').text();
                                let catSel = $('#selCat').val();
                                let areaSel = $('#selArea').val();
                                let tagSel = $('#selTag').val();
                                
                                if(searchIngr){
                                    $('#search').val(searchIngr);
                                
                                    $.ajax({
                                        url: '/recipes/request',
                                        method: 'post',
                                        data: formSelectionText,
                                        processData: false,
                                        contentType: false,
                                        
                                        beforeSend: function () {

                                            $('#loading').css('display','flex');
                                            $('div').remove('#container-list');

                                        },
                                        success: function(data) {
                                            if(data.message == 'success'){
                                                $.each(data, function(rowIndex,value){
                                                    switch(true){
                                                        case rowIndex == 'categories':
                                                            $('#selCat').html(value);
                                                            break;
                                                        case rowIndex == 'areas':
                                                            $('#selArea').html(value);
                                                            break;
                                                        case rowIndex == 'tags':
                                                            $('#selTag').html(value);
                                                            break;
                                                        case rowIndex == 'title':
                                                            $('#recipes-cards').css('display','inline-block');
                                                            $('#recipes-cards-title h1').html(value);
                                                            break;
                                                        case rowIndex == 'cards':
                                                            $('#recipes-cards-list').html(value);
                                                            break;
                                                    }
                                                });
                                            }else{
                                                $('#recipes-cards').css('display','none');
                                            }
                                        },
                                        complete: function() {
                                            $('#selCat option[value='+ catSel+']').attr('selected',true);
                                            $('#selArea option[value='+ areaSel +']').attr('selected',true);
                                            $('#selTag option[value='+ tagSel +']').attr('selected',true);

                                            $('#loading').css('display','none');         
                                        }

                                    });

                                }else{
                                    //Eliminate the event listners submit in case which user insert more than one letter
                                    $('#search').off('submit');
                                }
                                break;
                        }

                        if(currentFocus > count){
                            currentFocus = 0;
                        }else if(currentFocus < 0){
                            currentFocus = count;
                        }

                        //If the element exist
                        if($('.active').length){
                            $('div').removeClass('active');
                        }

                        //If the element exist
                        if($('.ingr-list').length){ 
                            $('.ingr-list')[currentFocus].classList.add('active');
                            //Scroll to the active element
                            $('.ingr-list')[currentFocus].scrollIntoView({ behavior: 'smooth' , block: 'nearest', inline: 'start'}); 
                        }

                    });

                    $('.ingr-list').on('click',function(event){

                        let formText = new FormData();
                        let csrfToken = $('#form-search input[name="_token"]').val();

                        let ingrSelected = event.target.innerText; //innerText detected by attributes nesting

                        $('#search').val(ingrSelected);

                        formText.append('_token',csrfToken);
                        formText.append('selCat',$('#selCat').val());
                        formText.append('selArea',$('#selArea').val());
                        formText.append('selTag',$('#selTag').val());
                        formText.append('wordIngr',ingrSelected);

                        let catSel = $('#selCat').val();
                        let areaSel = $('#selArea').val();
                        let tagSel = $('#selTag').val();
                        
                        $.ajax({
                                        
                            url: '/recipes/request',
                            method: 'post',
                            data: formText,
                            processData:false,
                            contentType:false,

                            beforeSend: function () {

                                $('#loading').css('display','flex');
                                $('div').remove('#container-list');

                            },
                            success: function(data) {

                                if(data.message == 'success'){
                                    $.each(data, function(rowIndex,value){
                                        switch(true){
                                            case rowIndex == 'categories':
                                                $('#selCat').html(value);
                                                break;
                                            case rowIndex == 'areas':
                                                $('#selArea').html(value);
                                                break;
                                            case rowIndex == 'tags':
                                                $('#selTag').html(value);
                                                break;
                                            case rowIndex == 'title':
                                                $('#recipes-cards').css('display','inline-block');
                                                $('#recipes-cards-title h1').html(value);
                                                break;
                                            case rowIndex == 'cards':
                                                $('#recipes-cards-list').html(value);
                                                break;
                                        }
                                    });
                                }else{
                                    $('#recipes-cards').css('display','none');
                                }

                            },
                            complete: function() {
                                $('#selCat option[value='+ catSel+']').attr('selected',true);
                                $('#selArea option[value='+ areaSel +']').attr('selected',true);
                                $('#selTag option[value='+ tagSel +']').attr('selected',true);

                                $('#loading').css('display','none');
                            }

                        });
                    });
                }
            });
        }else{
            $('div').remove('#container-list');
        }
    });

    $('#remove').on('click',function(event){
        event.preventDefault();

        if($('#search').val()){

            $('#search').val(null);

            if($('#container-list').length){
                $('div').remove('#container-list');
            }

            let removeIngr = new FormData();
            let csrfToken = $('#remove input[name="_token"]').val();

            let catSel = $('#selCat').val();
            let areaSel = $('#selArea').val();
            let tagSel = $('#selTag').val();

            removeIngr.append('_token',csrfToken);
            removeIngr.append('selCat',catSel);
            removeIngr.append('selArea',areaSel);
            removeIngr.append('selTag',tagSel);
            removeIngr.delete('wordIngr'); //remove wordIngr

            $.ajax({
                url: '/recipes/request',
                type: 'post',
                data: removeIngr,
                processData: false,
                contentType: false,

                beforeSend: function(){
                    $('#loading').css('display','flex');
                },
                success: function(data) {

                    $.each(data, function(rowIndex,value){              
                        switch(true){
                            case rowIndex == 'categories':
                                $('#selCat').html(value);
                                break;
                            case rowIndex == 'areas':
                                $('#selArea').html(value);
                                break;
                            case rowIndex == 'tags':
                                $('#selTag').html(value);
                                break;
                            case rowIndex == 'title':
                                $('#recipes-cards').css('display','inline-block');
                                $('#recipes-cards-title h1').html(value);
                                break;
                            case rowIndex == 'cards':                
                                $('#recipes-cards-list').html(value);
                                break;
                        }
                    });
                },
                complete: function() {  
                    $('#selCat option[value='+ catSel+']').attr('selected',true);
                    $('#selArea option[value='+ areaSel +']').attr('selected',true);
                    $('#selTag option[value='+ tagSel +']').attr('selected',true);
                                    
                    $('#loading').css('display','none');
                },
            });
        }
    });
});

/*-----------------------------------DIV GO-UP-ARROW-------------------------------------*/


const header = document.getElementsByTagName('header');
const buttonGoUp = document.getElementById('go-up-arrow');

window.onscroll = function(){
    if(this.scrollY > window.innerHeight && !window.matchMedia("(max-width: 800px)").matches){
        buttonGoUp.style.transform = 'scale(1)';
    }else{
        buttonGoUp.style.transform = 'scale(0)';
    }
}

buttonGoUp.onclick = function(){
    window.scrollTo({top: header, behavior: 'smooth'});
}

/*-----------------------------------PAGE SUBSCRIBE----------------------------------------*/

$('#email').on('invalid',function(){
    this.setCustomValidity('Please insert a valid email');
});