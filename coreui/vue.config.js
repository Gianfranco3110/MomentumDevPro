module.exports = {
  lintOnSave: false,
  runtimeCompiler: true,
  configureWebpack: {
    //Necessary to run npm link https://webpack.js.org/configuration/resolve/#resolve-symlinks
    resolve: {
       symlinks: false
    }
  }, chainWebpack: config => {
    config.module
      .rule('videos')
      .test(/\.(mp4|mov)$/)
      .use('file-loader')
      .loader('file-loader')
      .options({
        name: 'videos/[name].[hash:8].[ext]'
      })
      .end();
  }
}
