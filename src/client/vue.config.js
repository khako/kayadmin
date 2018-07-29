const path = require('path')
const projectRoot = path.resolve(__dirname)

module.exports = {
  configureWebpack: {
    resolve: {
      alias: {
        '@sass': path.join(projectRoot, 'assets/sass'),
        '@components': path.join(projectRoot, 'src/components')
      }
    }
  }
}
