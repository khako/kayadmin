const path = require('path')
const projectRoot = path.resolve(__dirname)
const HtmlWebpackPlugin = require('html-webpack-plugin')
console.log(process.env.NODE_ENV)
module.exports = {
    baseUrl: process.env.NODE_ENV === 'production' ? '/vendor/kaya/dist' : '/dist',

    configureWebpack: {
        plugins: [
            new HtmlWebpackPlugin({
                'template': path.join(projectRoot, '../views/index.html'),
                'filename':path.join(projectRoot, '../views/admin.blade.php')
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
