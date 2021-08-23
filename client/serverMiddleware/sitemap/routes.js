import axios from 'axios'
const { Router } = require('express')
const router = Router()

const { generateSitemap } = require('./parser')
let baseUrl =  process.env.API_URL;
let siteUrl = process.env.API_URL_BROWSER

router.get('/.xml', async function (req, res, next) {
  var siteMapCollection = []

  try {
    const customAxios = axios.create({
      baseURL: `${baseUrl}/api/`
    });
    let { data } = await customAxios.get('articles/seo');

    data.data.map(post => {

      let postObj = {
        loc:`/posts/${post.slug}`,
        changefreq: 'daily',
        priority: 1,
        lastmod: post.updated_at
      }
      siteMapCollection.push(postObj)

      let categoryObj = {
        loc:`/categories/${post.category.slug}`,
        changefreq: 'daily',
        priority: 1,
        lastmod: post.category.updated_at_dates.updated_at_format_1
      }

      var categoryExist = siteMapCollection.filter(function (category) {
        return (category.loc == categoryObj.loc);
      });

      if (categoryExist.length == 0){
        siteMapCollection.push(categoryObj);
      }
    });
  } catch (error) {
    if (error.response) {
      console.log(error.response.data);
      console.log(error.response.status);
      console.log(error.response.headers);
    } else if (error.request) {
      console.log(error.request);
    } else {
      console.log('Error', error.message);
    }
    console.log(error);
  }

  try {
      res.setHeader('Content-Type', 'application/xml');
      res.send(generateSitemap(siteMapCollection, siteUrl));
  } catch (e) {
    next(e)
  }
})

module.exports = router
