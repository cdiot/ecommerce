var list = document.querySelector("#list");
var items = Array.from(list.querySelectorAll(".item"));
var loadMore = document.getElementById("loadMore");
maxItems = Number(loadMore.dataset.loadMoreNbElement);
loadItems = Number(loadMore.dataset.loadMoreNbElement);
hiddenClass = "is-hidden";
hiddenItems = Array.from(document.querySelectorAll(".is-hidden"));

items.forEach(function (item, index) {
  if (index > maxItems - 1) {
    item.classList.add(hiddenClass);
  }
});

loadMore.addEventListener("click", function () {
  [].forEach.call(document.querySelectorAll("." + hiddenClass), function (
    item,
    index
  ) {
    if (index < loadItems) {
      item.classList.remove(hiddenClass);
    }

    if (document.querySelectorAll("." + hiddenClass).length === 0) {
      loadMore.style.display = "none";
    }
  });
});