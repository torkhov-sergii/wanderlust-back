$(function(){
    $('.js_user_rating').change(function () {

        let userRating = $(this).find(":selected").val();

        let placeId = $(this).data('place_id');

        $(this).parents('tr').removeClass().addClass('color_' + userRating);

        axios.post('/place/', {
            placeId: placeId,
            userRating: userRating,
        }).then((response) => {
            // console.log(response)
            // window.location.href = response.data.payrexx_redirect_link;

        }).catch((error) => {
            console.error(error);
            throw new Error(error);
        });
    });
});


