// const requires_auth = new Map();
// requires_auth.set("dashboard.php", true);
// requires_auth.set("dashboard_invites.php", true);
// requires_auth.set("header.php", false);
// requires_auth.set("index.php", false);
// requires_auth.set("login_form.php", false);
// requires_auth.set("login_signup.php", false);
// requires_auth.set("signup_form.php", false);
// requires_auth.set("spending_entry_log.php", true);
// requires_auth.set("spending_tracker.php", true);
// requires_auth.set("spending_user_log.php", true);

async function getContent(path, refresh, endpoint = null, data = null) {
    try {
        var response;
        //console.log("GETTING " + path);

        response = await fetch(path, {method: "GET"});

        if(response.ok) {
            if(refresh) {
                history.pushState(null, null, path);
                location.replace(location.href);
                return data;
            }
            return parseResponse(response, endpoint, refresh);
        }
    } catch (error) {
        console.error(error);
    }
}

async function getContentThenRedirect(path, endpoint = null) {
    try {
        var response;
        //console.log("GETTING " + path);

        response = await fetch(path, {method: "GET"});

        if(response.ok) {
            return parseResponse(response, endpoint, true);
        }
    } catch (error) {
        console.error(error);
    }
}

async function postContent(path, data, endpoint) {
    try {
        var response;
        //console.log("POSTING " + JSON.stringify(data));

        if(Object.hasOwn(data, 'password')) {
            //Security Here!
            console.log("We should encrypt the pasword now!");
        }

        response = await fetch(path, {
            method: "POST",
            body: JSON.stringify(data),
            headers: {"Content-Type": "application/json; charset=UTF-8"}
        });

        if(response.ok) {
            var startpointCompare = location.href.indexOf('?') > 0 ? location.href.substring(location.href.indexOf("endpoint=") + 9) : location.href.substring(location.indexOf("programs/"));
            var endpointCompare = endpoint.indexOf('?') > 0 ? endpoint.substring(0, endpoint.indexOf('?')) : endpoint;
            var shouldRefresh = (startpointCompare != endpointCompare);

            return parseResponse(response, endpoint, shouldRefresh);
        }else {
            console.log(response.status);
        }
    } catch (error) {
        console.error(error);
    }
}

async function putContent(path, data, endpoint) {
    try {
        var response;
        //console.log("PUTTING " + JSON.stringify(data));

        if(Object.hasOwn(data, 'password')) {
            //Security Here!
            console.log("We should encrypt the pasword now!");
        }

        response = await fetch(path, {
            method: "PUT",
            body: JSON.stringify(data),
            headers: {"Content-Type": "application/json; charset=UTF-8"}
        });

        if(response.ok) {
            var startpointCompare = location.href.indexOf('?') > 0 ? location.href.substring(location.href.indexOf("endpoint=") + 9) : location.href.substring(location.indexOf("programs/"));
            var endpointCompare = endpoint.indexOf('?') > 0 ? endpoint.substring(0, endpoint.indexOf('?')) : endpoint;
            var shouldRefresh = (startpointCompare != endpointCompare);

            return parseResponse(response, endpoint, shouldRefresh);
        }else {
            console.log(response.status);
        }
    } catch (error) {
        console.error(error);
    }
}

async function deleteContent(path, refresh) {
    try {
        var response;
        //console.log("DELETING " + path);

        response = await fetch(path, {method: "DELETE"});

        if(response.ok) {
            if(refresh) {
                history.pushState(null, null, path);
                location.replace(location.href);
            }
        }
    } catch (error) {
        console.error(error);
    }
}

function parseResponse(response, endpoint, refresh = false) {
    var promise = response.json().then((data)=>{
        //console.log(JSON.stringify(data));
        console.log(data);
        console.log(data.message);

        document.querySelector(".request-content").textContent = data.message;
        switch(data.resource) {
            case "users":
                if(data.type === "create" || data.type === "update" || data.type === "login" || data.type === "logout") {
                    var users = [];
                    for(var i = 0; i < data.user_id.length; i++) {
                        users.push(new User(data.user_id[i], data.username[i], data.email[i]));
                    }

                    console.log("Logging users from POST request");
                    console.log(users);

                    if(data.type === "login" || data.type === "logout" || data.type === "create") {
                        sessionStorage.clear();
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, users);
                    }
                    return users;
                }else if(data.type === "retrieve") {
                    var users = [];
                    for(var i = 0; i < data.user_id.length; i++) {
                        users.push(new User(data.user_id[i], data.username[i], data.email == null ? "Unknown Email" : data.email[i]));
                    }

                    console.log("Logging users from GET request");
                    console.log(users);

                    if(data.type === "login" || data.type === "logout" || data.type === "create") {
                        sessionStorage.clear();
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, users);
                    }
                    return users;
                }else {
                    //Show deleted progress???
                    console.log("Deleted user " + data.user_id + ". Response: " + response.status + " " + response.statusText);
                }
                break;
            case "trackers":
                if(data.type === "create" || data.type === "update") {
                    var tracker = new SpendingTracker(data.tracker_id, data.tracker_name);

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, tracker); //getContent(request, refresh, endpoint, data)
                    }
                    return tracker;
                }else if(data.type === "retrieve") {
                    var trackers = [];
                    for(var i = 0; i < data.tracker_id.length; i++) {
                        trackers.push(new SpendingTracker(data.tracker_id[i], data.tracker_name[i]));
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, trackers); //getContent(request, refresh, endpoint, data)
                    }
                    return trackers;
                }else if(data.type === "retrieve/preview") {
                    var trackers = [];
                    for(var i = 0; i < data.tracker_id.length; i++) {
                        var tracker = new SpendingTracker(data.tracker_id[i], data.tracker_name[i]);
                        for(var j = 0; j < data.entry_id[i].length; j++) {
                            tracker.addEntry(new SpendingEntry(data.entry_id[i][j], data.entry_user_id[i][j], data.amount[i][j], data.date[i][j], data.desc[i][j], false));
                        }
                        trackers.push(tracker);
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, trackers); //getContent(request, refresh, endpoint, data)
                    }
                    return trackers;
                }else {
                    //Show deleted progress???
                    console.log("Deleted user " + data.user_id + ". Response: " + response.status + " " + response.statusText);
                }
                break;
            case "entries":
                if(data.type === "retrieve") {
                    var entries = [];
                    for(var i = 0; i < data.entry_id.length; i++) {
                        entries.push(new SpendingEntry(data.entry_id[i], data.user_id[i], data.amount[i], data.date[i], data.desc[i], false));
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, entries);
                    }
                    return entries;
                }else if(data.type === "create" || data.type === "update") {
                    var entry = new SpendingEntry(data.entry_id, data.user_id, data.amount, data.date, data.desc, false);

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, endpoint, entry);
                    }
                    return entry;
                }else {
                    //Show deleted progress???
                    console.log("Deleted user " + data.sender_id + ". Response: " + response.status + " " + response.statusText);
                }
            case "invites":
                if(data.type === "create" || data.type === "accept" || data.type === "ignore") {
                    var invite = new Invite(data.invite_id, data.sender_id, data.recipient_id, data.is_friend_request, data.list_id, data.tracker_id, data.create_time, data.expire_time);

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, invite);
                    }
                    return invite;
                }else if(data.type === "retrieve") {
                    var invites = [];
                    for(var i = 0; i < data.invite_id.length; i++) {
                        invites.push(new Invite(data.invite_id[i], data.sender_id[i], data.recipient_id, data.is_friend_request[i], data.list_id[i], data.tracker_id[i], data.create_time[i], data.expire_time[i]));
                    }

                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?endpoint=" + endpoint, true, invites);
                    }
                    return invites;
                }else {
                    //Show deleted progress???
                    console.log("Deleted user " + data.user_id + ". Response: " + response.status + " " + response.statusText);
                }
                break;
            case "friends":
                if(data.type === "create" || data.type === "update" || data.type === "retrieve") {
                    if(refresh) {
                        getContent("/programs/ShopMate/pages/index.php?request=friends/" + data.user_id + "&endpoint=" + endpoint, true);
                    }
                }else {
                    //Show deleted progress???
                    console.log("Deleted user " + data.user_id + ". Response: " + response.status + " " + response.statusText);
                }
                break;
        }
    });
    return promise;
}

function setData(sessionStorageItem, sessionStorageData) {
    sessionStorage.setItem(sessionStorageItem, sessionStorageData);
}

function setDataAndRedirect(redirect, sessionStorageItem, sessionStorageData) {
    sessionStorage.setItem(sessionStorageItem, sessionStorageData);
    //getContent(redirect, true);
}

// Listen for the 'popstate' event to handle browser back/forward
// window.addEventListener('popstate', (event) => {
//     parsePath(location.pathname, null, true);
// });