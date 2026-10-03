const RSS_PROXY = 'https://api.rss2json.com/v1/api.json?rss_url='
async function test() {
  const url = RSS_PROXY + encodeURIComponent('https://rss.arxiv.org/rss/cs.AI') + '&count=20'
  const resp = await fetch(url)
  const data = await resp.json()
  console.log(data.status, data.items?.length)
}
test()
