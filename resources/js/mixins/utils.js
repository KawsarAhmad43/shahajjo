export default {
    methods: {
        scrollTop(x = 0, y = 0) {
            window.scrollTo(x, y)
        },

          ucfirst(str) {
              if (typeof str !== 'string' || str.length === 0) {
                  return str;
              }

              return str.charAt(0).toUpperCase() + str.slice(1);
        },

        // SET Breadcrumbs
        setBreadcrumbs(model, type, model_name) {
            let modelName = model_name ? model_name : model;
            if (type == 'index') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" }
                ];
            } if (type == 'create') {
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".create", title: modelName + " Create" }
                ];
            } else if (type == 'edit') {
                let slug = this.$route.params.slug ? this.$route.params.slug : this.$route.params.id
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".edit", title: modelName + " Edit", slug: slug }
                ];
            } else if (type == 'view') {
                let slug = this.$route.params.slug ? this.$route.params.slug : this.$route.params.id
                var breadcrumb = [
                    { route: model + ".index", title: modelName + " List" },
                    { route: model + ".show", title: modelName + " View", slug: slug }
                ];
            }
            this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
        },

        // SHOW IMAGE
        showImage(e, imagePath, dataPath, fileClass = null, pdf = null) {
            $("." + fileClass).children('.custom-file-label').html("File attached");
            let files = e.target.files || e.dataTransfer.files;
            if (files.length) {
                this.image[imagePath] = e.target.files[0];
                if (dataPath) {
                    if (pdf) {
                        this.data[dataPath] = this.attach;
                    } else {
                        this.data[dataPath] = URL.createObjectURL(e.target.files[0]);
                    }
                }
            }
        },

        // SHOW GLOBALLY IMAGE
        showImageGlobal(file, field, pdf = null) {
            if (file && field) {
                this.data()[field] = file;
                if (pdf) {
                    this.image[field] = this.attach;
                } else {
                    this.image[field] = URL.createObjectURL(file);
                }
            }
        },
        // SHOW CROP IMAGE
        // showCropImage(event, field, fileClass = null) {
        //     $(".attached").html("File attached");
        //     var input = event.target;
        //     if (input.files && input.files[0]) {
        //         var reader = new FileReader();
        //         reader.onload = e => {
        //             this.$parent.image[field] = e.target.result;
        //         };
        //         reader.readAsDataURL(input.files[0]);
        //     }
        //     // this.$bvModal.show('canvas')
        // },

        // print html page
        print: function (elementId, documentTitle) {
            $(".action").css("display", "none");
            $(".sort-up").css("display", "none");
            $(".base-table-thead").removeClass("bg-purple text-white");

            setTimeout(() => {
                $(".action").show();
                $(".base-table-thead").addClass("bg-purple text-white");
            }, 500);
            const prtHtml = document.getElementById(elementId).innerHTML;
            let customStyle = '<style>table{border-collapse: collapse;}</style>'
            let stylesHtml = '';
            for (const node of [...document.querySelectorAll('link[rel="stylesheet"], style')]) {
                stylesHtml += node.outerHTML;
            }
            const WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.write(`<!DOCTYPE html>
                <html>
                <head>
                <title>${documentTitle}</title>
                ${stylesHtml}
                ${customStyle}
                </head>
                <body>
                    ${prtHtml}
                </body>
                </html>`);
            WinPrint.document.close();
            WinPrint.focus();
            setTimeout(() => WinPrint.print(), 300);
            // WinPrint.close();
        }
    }
}
