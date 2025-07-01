<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tech News @yield('title')</title>
    <script src="/js/tailwindcss.3.4.16.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: "#c00", secondary: "#2a5885" },
                    borderRadius: {
                        none: "0px",
                        sm: "4px",
                        DEFAULT: "8px",
                        md: "12px",
                        lg: "16px",
                        xl: "20px",
                        "2xl": "24px",
                        "3xl": "32px",
                        full: "9999px",
                        button: "8px",
                    },
                },
            },
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"
        rel="stylesheet"
    />
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap"
        rel="stylesheet"
    />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css"
    />
    <style>
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .news-category {
            border-bottom: 2px solid #f0f0f0;
        }
        .news-category-title {
            border-bottom: 2px solid #c00;
            margin-bottom: -2px;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .search-input:focus {
            outline: none;
        }
        .back-to-top {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        :where([class^="ri-"])::before { content: "\f3c2"; }
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
        }
        .news-category {
            border-bottom: 2px solid #f0f0f0;
        }
        .news-category-title {
            border-bottom: 2px solid #c00;
            margin-bottom: -2px;
        }
        .sticky-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        .search-input:focus {
            outline: none;
        }
        .back-to-top {
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }
        .filter-active {
            color: #c00;
            font-weight: 500;
            border-bottom: 2px solid #c00;
        }
    </style>
</head>
