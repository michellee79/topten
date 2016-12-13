/**
 * Created by alex on 7/30/2016.
 */
function are_cookies_enabled()
{
    var cookieEnabled = (navigator.cookieEnabled) ? true : false;

    if (typeof navigator.cookieEnabled == "undefined" && !cookieEnabled)
    {
        document.cookie="testcookie";
        cookieEnabled = (document.cookie.indexOf("testcookie") != -1) ? true : false;
    }
    return (cookieEnabled);
}

if(!are_cookies_enabled()) {
    alert("Your browser is blocking cookies from this site. Please enable cookie before using this site.");
    window.location = '/error/404';
}