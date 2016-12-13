$(document).ready(function () {

    $('#ddlGroupCategory').live("change", function () {
        cat = $("#ddlGroupCategory").val();
        ga('send', 'event', 'GroupCategory', 'click', cat);
        filterBusiness('', 0);
    });

    $('#ddlGroupCategoryMobile').live("change", function () {
        cat = $("#ddlGroupCategoryMobile").val();
        ga('send', 'event', 'GroupCategory', 'click', cat);
        filterBusiness('Mobile', 0);
    });

    $('#ddlCategory').live("change", function () {
        cat = $("#ddlCategory")[0].options[$("#ddlCategory")[0].selectedIndex].text;
        ga('send', 'event', 'Category', 'click', cat);
        filterBusiness('', 1);
    });

    $('#ddlCategoryMobile').live("change", function () {
        cat = $("#ddlCategoryMobile")[0].options[$("#ddlCategoryMobile")[0].selectedIndex].text;
        ga('send', 'event', 'Category', 'click', cat);
        filterBusiness('Mobile', 1);
    });

    $('#ddlSubCategory').live("change", function () {
        cat = $("#ddlSubCategory")[0].options[$("#ddlSubCategory")[0].selectedIndex].text;
        ga('send', 'event', 'SubCategory', 'click', cat);
        filterBusiness('', 2);
    });

    $('#ddlSubCategoryMobile').live("change", function () {
        cat = $("#ddlSubCategoryMobile")[0].options[$("#ddlSubCategoryMobile")[0].selectedIndex].text;
        ga('send', 'event', 'SubCategory', 'click', cat);
        filterBusiness('Mobile', 2);
    });

    $('#ddlRadius').live("change", function () {
        cat = $("#ddlRadius")[0].options[$("#ddlRadius")[0].selectedIndex].text;
        ga('send', 'click', 'Category', cat, cat);
        filterBusiness('', 3);
    });

    $('#ddlRadiusMobile').live("change", function () {
        cat = $("#ddlRadiusMobile")[0].options[$("#ddlRadiusMobile")[0].selectedIndex].text;
        ga('send', 'event', 'Radius', 'click', cat);
        filterBusiness('Mobile', 3);
    });

    $('.filter').click(function () {
        $(this).parent().toggleClass('toggle');
        $(this).find('.arrow').toggleClass('toggle');
        $(this).parent().find('.subSubMenu').toggle('medium');
    });


    $('.info').click(function () {
        $(this).parent().find('.summary').toggle('medium');
    });

    // $('a[href*=#]:not([href=#])').click(function() {
    $('a[href*=#body]').click(function() {
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
          if (target.length) {
            $('html,body').animate({
              scrollTop: target.offset().top
            }, 1000);
            return false;
          }
        }
      });
    
    $(document).scroll(function() {
      var y = $(this).scrollTop();
      if (y > 800) {
        $('.moveTop').fadeIn();
      } else {
        $('.moveTop').fadeOut();
      }
    });

    $("#search").keyup(function(event){
        if(event.keyCode == 13){
            search('');
        }
    });
});

function showMobileFilter() {
    hideLoading();
    $('.mobileFilter').show();
    $('.arrowMobileFilter').addClass('toggle');
}

function filterBusiness(suffix, update){
    g = $("#ddlGroupCategory" + suffix).val();
    c = $("#ddlCategory" + suffix).val();
    s = $("#ddlSubCategory" + suffix).val();
    r = $("#ddlRadius" + suffix).val();

    $("#search").val('');

    if (c == null)
        c = '';
    if (s == null)
        s = '';

    if (suffix == 'Mobile'){
        $('.filter').show();
    } else{
        showLoading();
    }

    $.ajax({
        url : '/ajax/filterbusiness',
        type : 'post',
        dataType : 'json',
        success: function(data){
            
            if (data.success == 'true'){
                $("#businessesMobile").html(data.renderMobile);
                $("#businesses").html(data.render);

                updateCategory(data, update);
                businesses = JSON.parse(data.businessesJson);
                refreshMap();
            }
            if (suffix == 'Mobile'){
                $('.filter').hide();
            } else{
                hideLoading();
            }
        },
        data : {
            group: g,
            category: c,
            subcategory: s,
            radius: r
        }
    });
}

function search(mobile){
    $("#ddlCategory").val('');
    $("#ddlSubCategory").val('');
    $("#ddlGroupCategory").val('');
    $("#ddlCategory").attr('disabled', 'disabled');
    $("#ddlSubCategory").attr('disabled', 'disabled');

    r = $("#ddlRadius" + mobile).val();
    s = $("#search" + mobile).val();

    ga('send', 'event', 'Business', 'search', s);

    showLoading();

    $.ajax({
        url : '/ajax/findbusiness/' + r + '/' + s,
        type : 'get',
        dataType : 'json',
        async: false,
        success: function(data){
            
            if (data.success == 'true'){
                $("#businessesMobile").html(data.renderMobile);
                $("#businesses").html(data.render);

                businesses = JSON.parse(data.businessesJson);
                refreshMap();

                if (mobile == 'Mobile'){
                    $('.filter').hide();
                } else{
                    hideLoading();
                }
            } else{
                hideLoading();
                window.open('/nominate/' + s, '_blank');
            }
        }
    });
}

function updateCategory(data, update){
    if (update <= 1){
        $("#ddlSubCategory").empty();
        $("#ddlSubCategoryMobile").empty();
        addItemTo("ddlSubCategory", "", "Filter by Sub Category");
        addItemTo("ddlSubCategoryMobile", "", "Filter by Sub Category");

        if (data.subcategories == null){
            $("#ddlSubCategory").attr('disabled', 'disabled');
            $("#ddlSubCategoryMobile").attr('disabled', 'disabled');
        } else{
            $("#ddlSubCategory").removeAttr('disabled');
            $("#ddlSubCategoryMobile").removeAttr('disabled');

            $.each(data.subcategories, function (i, item) {
                addItemTo('ddlSubCategory', item.id, item.subCategory);
                addItemTo('ddlSubCategoryMobile', item.id, item.subCategory);
            });
        }
    }

    if (update == 0){
        $("#ddlCategory").empty();
        $("#ddlCategoryMobile").empty();
        addItemTo("ddlCategory", "", "Filter by Business Category");
        addItemTo("ddlCategoryMobile", "", "Filter by Business Category");

        if (data.categories == null){
            $("#ddlCategory").attr('disabled', 'disabled');
            $("#ddlCategoryMobile").attr('disabled', 'disabled');
        } else{
            $("#ddlCategory").removeAttr('disabled');
            $("#ddlCategoryMobile").removeAttr('disabled');
            $.each(data.categories, function (i, item) {
                addItemTo('ddlCategory', item.id, item.category);
                addItemTo('ddlCategoryMobile', item.id, item.category);
            });
        }
    }

}

function addItemTo(targetId, val, txt){
    $('#' + targetId).append($('<option>', {
        value: val,
        text: txt
    }));
}