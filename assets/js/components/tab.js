export default class Tab {
    constructor(container) {
        this.$els = {
            container: container,
            id: container.getAttribute('data-id'),
            containers: [...document.querySelectorAll('.js-tab-container')],
            tabgroups: [...document.querySelectorAll('.js-tab-group')]

        }

        this.buttons = [...document.querySelectorAll(`[data-target="${this.$els.id}"]`)]
        this.groups = [...document.querySelectorAll(`[data-target="groupe-${this.$els.id}"]`)]


        this.$options = {
			visible: 'visible',
            visibleflex: 'visible-flex'
		}

        this.initEvents()
	}

	initEvents () {
       this.buttons.forEach(opener => opener.addEventListener('click', () => this.open()))
    }

    open () {
        this.$els.containers.forEach(container => {
            container.classList.remove(this.$options.visible)
        })

        this.$els.tabgroups.forEach(container => {
            container.classList.remove(this.$options.visibleflex)
        })

        this.$els.container.classList.add(this.$options.visible)

        this.groups.forEach(container => {
            container.classList.add(this.$options.visibleflex)
        })
    }
}
