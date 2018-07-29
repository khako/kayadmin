const path = require('path')
const projectRoot = path.resolve(__dirname)
const HtmlWebpackPlugin = require('html-webpack-plugin')

module.exports = {
    baseUrl: process.env.NODE_ENV === 'production' ? '/vendor/kaya/admin/' : '/dist',

    configureWebpack: {
        plugins: [
            new HtmlWebpackPlugin({
                'template': path.join(projectRoot, 'public/index.html'),
                'filename':path.join(projectRoot, '../src/views/admin.blade.php')
            })
        ],

        resolve: {
            alias: {
                '@sass': path.join(projectRoot, 'assets/sass'),
                '@components': path.join(projectRoot, 'src/components')
            }
        }
    }
}
