var clickedIndex = 0;

$('#searchText').keypress(function (e) {
    var key = e.which;
    if(key == 13)
    {
        $("#searchuserbtn").click();
        return false;
    }
});

$("#searchuserbtn").click(function(e){
   if(clickedIndex > 0)
   {
       var searchText = $("#searchText").val();
       getUserList(clickedIndex, searchText);
   }
});

$(".tilediv").click(function(e) {
    $("#searchText").val("");
    var divId = $(this).attr("id");
    clickedIndex = divId.replace("tile", "");
    $('.tileorgtitle').css('color', 'darkgray');
    $('#title' + clickedIndex).css('color', 'black');
    $('.tileimage').css('border', 'none');
    $('.tileimage').html('');
    $('.tileimage').append('<div class="tileimage" style="margin-top: -40%; background-color: rgba(255,255,255,0.3); width: 100%;"></div>');

    $('#img' + clickedIndex).css('border', 'solid');
    $('#img' + clickedIndex).css('border-width', '3px');
    $('#img' + clickedIndex).css('border-color', '#E17933');
    $('#img' + clickedIndex).html('');

    $("#searchbox").show();
    $("#usersection").show();
    var searchText = $("#searchText").val();

    getUserList(clickedIndex, searchText);
});

function getUserList(tileId, searchName) {
    clickedIndex = tileId;
    var postdata = {tileid: tileId, searchname:searchName};
    console.log(postdata);

    $.ajax({
        type: 'POST',
        url: '/admin/gettileuser',
        dataType: 'json',
        data:postdata,
        error: function (xhr, err) {
            console.log(err);
            drawEmptyTable();
        },
        success: function(data)
        {
            console.log(data);
            var userDatas = data['userInfos'];
            var userCounts = userDatas.length;
            if(userCounts > 0)
            {

                    drawUserTable(userDatas);

            }
            else
            {
                drawEmptyTable();
            }
        }
    });
}

function drawUserTable(userInfos) {
    $('.userlistdiv').html('');

    var userCount = userInfos.length;

    var i = 0;
    $.each(userInfos, function(id, userData)
    {
        i = i + 1;
        var userName = userData['full_name'];
        var phoneNumber = userData['phonenumber'];
        var userID = userData['id'];

        var domainurl = document.location.origin + '/';
        var samplePicture = domainurl + 'img/profile/sample.png';
        var profilePicture = userData['profile_picture'];

        if(profilePicture == "")
        {
            profilePicture = samplePicture;
        }
        else
        {
            profilePicture = domainurl + profilePicture;

            var image = new Image();
            image.src = profilePicture;

            if(image.width == 0)
            {
                profilePicture = samplePicture;
            }
        }

        var userTableDiv = '<div class="userlistcelldiv">' +
                                '<div class="userlistprofilediv">' +
                                    '<div style="max-width: 60px; ">' +
                                        '<img src="' +  profilePicture + '" class="img-circle" style="max-width: 50px;" />' +
                                    '</div>' +
                                    '<div style="margin-left: 10px;">' +
                                        '<h5><b>' + userName + '</b>' +
                                        '<br>+ ' + phoneNumber + '</h5>' +
                                    '</div>' +
                                '</div>' +

                                '<div class="optdiv">' +
                                    '<input id="radio' + userID + '" type="radio" style="margin-right: 30px" disabled>' +
                                    '<button id="invite' + userID + '" class="btn btn-warning invite-btn">Invite</button>' +
                                '</div>' +
            // '<div class="optdiv">' +
            // '<input type="radio" style="margin-right: 30px" disabled checked>' +
            // '<button class="btn btn-warning invite-btn" disabled>Invite Sent</button>' +
            // '</div>' +
                            '</div>';
        if(i < userCount)
        {
            userTableDiv = userTableDiv +
                                '<div class="cellspacediv">' +
                                   '<div class="separatordiv1"></div>' +
                                '</div>';
        }
        $('.userlistdiv').append( userTableDiv );
    });

    $(".invite-btn").click(function(e) {
        var clickedUserID = 0;
        var btnID = $(this).attr("id");
        clickedUserID = btnID.replace("invite", "");

        $('#' + btnID).attr("disabled", true);
        $('#' + btnID).text("Invite Sent");

        $('#radio' + clickedUserID).prop('checked', true);
    });

    window.scrollTo(0,0);
}

function drawEmptyTable() {
    $('.userlistdiv').html('');
    $('.userlistdiv').append( '<div style="width:100%; text-align: center"><p style="margin-top: 23px;"><h4>No data to display</h4></p></div>' );

    window.scrollTo(0,0);
}