function ftoast(icon, message, duration = 3000){
    return new Promise((resolve, _) => {
        const body = $("body");
        let hIcon = "";

        if(icon === "error") hIcon = '<i class="fa fa-exclamation-circle danger"></i>';
        if(icon === "success") hIcon = '<i class="fa fa-check-circle success"></i>';

        body.prepend(`
            <aside class="alert-box active">
                <div class="alert-content">
                    ${hIcon}
                    <span>${message}</span>
                </div>
            </aside>
        `);

        setTimeout(() => {
            const alertEl = $(".alert-box");

            alertEl.removeClass("active");
            alertEl.addClass("remove");

            setTimeout(() => {
                alertEl.remove();

                resolve("done");
            }, 800);
        },
        duration);
    });
}