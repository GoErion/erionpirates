<!-- Dark Mode: Shows white "Erion" -->
<svg
    {{ $attributes->merge(['class' => 'dark:block hidden']) }}
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 200 50"
>
    <text
        x="0"
        y="35"
        font-size="40"
        fill="#FFFFFF"
        font-family="sans-serif"
        font-weight="bold"
    >
        Erion
    </text>
</svg>

<!-- Light Mode: Shows dark "Erion" -->
<svg
    {{ $attributes->merge(['class' => 'dark:hidden block']) }}
    xmlns="http://www.w3.org/2000/svg"
    viewBox="0 0 200 50"
>
    <text
        x="0"
        y="35"
        font-size="40"
        fill="#0F172A"
        font-family="sans-serif"
        font-weight="bold"
    >
        Erion
    </text>
</svg>
