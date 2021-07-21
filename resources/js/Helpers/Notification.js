class Notification {
    success() {
        new Noty({
            // theme: "sunset",
            type: "success",
            layout: "topRight",
            text: "Successfully done..",
            timeout: 1000
        }).show();
    }

    alert() {
        new Noty({
            type: "alert",
            layout: "topRight",
            text: "Are You sure?",
            timeout: 1000
        }).show();
    }

    error() {
        new Noty({
            type: "alert",
            layout: "topRight",
            text: "Something went wrong.",
            timeout: 1000
        }).show();
    }

    warning() {
        new Noty({
            type: "warning",
            layout: "topRight",
            text: "Ops, something went wrong.",
            timeout: 1000
        }).show();
    }

    image_validation() {
        new Noty({
            type: "error",
            layout: "topRight",
            text: "Image size should be less than 1MB",
            timeout: 2000
        }).show();
    }
}

export default Notification = new Notification();