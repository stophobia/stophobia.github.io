const useMarkdownItVueExample = require('./utils/use-markdown-it-vue-example')

module.exports = {
  title: 'Stophobia',
  configureWebpack: {
    resolve: {
      alias: require('../aliases.config').webpack,
    },
  },
  head: [
    [
      'link',
      {
        rel: 'shortcut icon',
        type: 'image/x-icon',
        href: `./static/img/site/favicon.ico`,
      },
    ],
  ],
  markdown: {
    config: useMarkdownItVueExample,
  },
  themeConfig: {
    sidebar: [['/', 'Home'], ['/contents/intro', 'Good Coding']],
  },
}
