const xmlHeader = '<?xml version="1.0" encoding="UTF-8"?>'
module.exports = {
  generateSitemap(sitemap, host) {
    let xml = `${xmlHeader}<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">`

    sitemap.forEach((item) => {
      xml += `<url><loc>${host}${item.loc}</loc><lastmod>${item.lastmod}</lastmod><changefreq>${item.changefreq}</changefreq><priority>${item.priority}</priority></url>`
    })

    xml += '</urlset>'
    return xml
  }
}
