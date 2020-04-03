
module.exports = {
    theme: {
        extend: {
            colors: {
                gray: {
                    '100': '#F5F6F9',
                    '200': 'rgb(0, 0, 0, 0.4)',
                },
                blue: {
                    '400': '#47cdff',
                    '500': '#8ae2fe',
                },
                'page': 'var(--page-background-color)', // use variable page-background-color
                'card': 'var(--card-background-color)',
                'button': 'var(--button-background-color)',
                'header': 'var(--header-background-color)',
                'default': 'var(--text-default-color)',
                'accent': 'var(--text-accent-color)',
                'accent-light': 'var(--text-accent-light-color)',
                'muted': 'var(--text-muted-color)',
                'muted-light': 'var(--text-muted-light-color)',
            }
        },
    },
    variants: {},
    plugins: [],
    shadows: {
        default: '0 0 5px 0 rbga(0, 0, 0, 0, 0.08)'
    },
};
