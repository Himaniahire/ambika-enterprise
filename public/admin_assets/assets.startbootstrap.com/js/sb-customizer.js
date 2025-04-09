(window.webpackJsonpSBCustomizer = window.webpackJsonpSBCustomizer || []).push([
    [1],
    {
        "/9aa": function (t, e, n) {
            var r = n("NykK"),
                s = n("ExA7");
            t.exports = function (t) {
                return (
                    "symbol" == typeof t || (s(t) && "[object Symbol]" == r(t))
                );
            };
        },
        "/CYg": function (t, e, n) {
            var r = n("MSY3"),
                s = n("KdVd"),
                i = n("sVnn"),
                o = n("LCQ0"),
                a = i.validateRgb,
                l = i.labToRgb,
                c = i.labToRgbHex,
                u = i.labToHcl,
                h = i.diffSort,
                d = {
                    colorFilter: null,
                    colorSpace: "default",
                    clustering: "k-means",
                    quality: 50,
                    ultraPrecision: !1,
                    distance: "euclidean",
                    seed: null,
                },
                p = new Set(["force-vector", "k-means"]),
                f = new Set([
                    "euclidean",
                    "cmc",
                    "compromise",
                    "protanope",
                    "deuteranope",
                    "tritanope",
                ]),
                g = new Set(Object.keys(o));
            t.exports = function (t, e) {
                if ("number" != typeof t || t < 2)
                    throw new Error("iwanthue: expecting a color count > 2.");
                e = (function (t) {
                    var e = Object.assign({}, d, t);
                    if (e.colorFilter && "function" != typeof e.colorFilter)
                        throw new Error(
                            "iwanthue: invalid `colorFilter` setting. Expecting a function."
                        );
                    if (!p.has(e.clustering))
                        throw new Error(
                            'iwanthue: unknown `clustering` "' +
                                e.clustering +
                                '".'
                        );
                    if (
                        "number" != typeof e.quality ||
                        isNaN(e.quality) ||
                        e.quality < 1
                    )
                        throw new Error(
                            "iwanthue: invalid `quality`. Expecting a number > 0."
                        );
                    if ("boolean" != typeof e.ultraPrecision)
                        throw new Error(
                            "iwanthue: invalid `ultraPrecision`. Expecting a boolean."
                        );
                    if (!f.has(e.distance))
                        throw new Error(
                            'iwanthue: unknown `distance` "' + e.distance + '".'
                        );
                    if (
                        ("string" == typeof e.seed &&
                            (e.seed = (function (t) {
                                for (var e = 0, n = 0, r = t.length; n < r; n++)
                                    e += t.charCodeAt(n);
                                return e;
                            })(e.seed)),
                        null !== e.seed && "number" != typeof e.seed)
                    )
                        throw new Error(
                            "iwanthue: invalid `seed`. Expecting an integer or a string."
                        );
                    if (
                        !e.colorFilter &&
                        e.colorSpace &&
                        "all" !== e.colorSpace
                    ) {
                        var n;
                        if ("string" == typeof e.colorSpace) {
                            if (!g.has(e.colorSpace))
                                throw new Error(
                                    'iwanthue: unknown `colorSpace` "' +
                                        e.colorSpace +
                                        '".'
                                );
                            n = o[e.colorSpace];
                        } else if (Array.isArray(e.colorSpace)) {
                            if (6 !== e.colorSpace.length)
                                throw new Error(
                                    "iwanthue: expecting a `colorSpace` array of length 6 ([hmin, hmax, cmin, cmax, lmin, lmax])."
                                );
                            n = e.colorSpace;
                        } else
                            n = [
                                e.colorSpace.hmin || 0,
                                e.colorSpace.hmax || 360,
                                e.colorSpace.cmin || 0,
                                e.colorSpace.cmax || 100,
                                e.colorSpace.lmin || 0,
                                e.colorSpace.lmax || 100,
                            ];
                        e.colorFilter =
                            n[0] < n[1]
                                ? function (t, e) {
                                      var r = u(e);
                                      return (
                                          r[0] >= n[0] &&
                                          r[0] <= n[1] &&
                                          r[1] >= n[2] &&
                                          r[1] <= n[3] &&
                                          r[2] >= n[4] &&
                                          r[2] <= n[5]
                                      );
                                  }
                                : function (t, e) {
                                      var r = u(e);
                                      return (
                                          (r[0] >= n[0] || r[0] <= n[1]) &&
                                          r[1] >= n[2] &&
                                          r[1] <= n[3] &&
                                          r[2] >= n[4] &&
                                          r[2] <= n[5]
                                      );
                                  };
                    }
                    return e;
                })(e);
                var n = new r(e.seed),
                    i = function () {
                        return n.nextFloat();
                    },
                    m = new s().get(e.distance),
                    y = function (t, n) {
                        return !(
                            !a(t) ||
                            (e.colorFilter && !e.colorFilter(t, n))
                        );
                    },
                    v = (function (t, e, n) {
                        for (var r, s, i = new Array(e), o = 0; o < e; o++) {
                            do {
                                (r = [
                                    100 * t(),
                                    100 * (2 * t() - 1),
                                    100 * (2 * t() - 1),
                                ]),
                                    (s = l(r));
                            } while (!n(s, r));
                            i[o] = r;
                        }
                        return i;
                    })(i, t, y);
                return (
                    "force-vector" === e.clustering
                        ? (function (t, e, n, r, s) {
                              for (
                                  var i,
                                      o,
                                      a,
                                      c,
                                      u,
                                      h,
                                      d,
                                      p,
                                      f,
                                      g,
                                      m,
                                      y,
                                      v,
                                      b = new Array(r.length),
                                      w = 20 * s.quality,
                                      C = r.length;
                                  w-- > 0;

                              ) {
                                  for (i = 0; i < C; i++)
                                      b[i] = { dl: 0, da: 0, db: 0 };
                                  for (i = 0; i < C; i++)
                                      for (a = r[i], o = 0; o < i; o++)
                                          (u = e(a, (c = r[o]))) > 0
                                              ? ((h = a[0] - c[0]),
                                                (d = a[1] - c[1]),
                                                (p = a[2] - c[2]),
                                                (f = 100 / Math.pow(u, 2)),
                                                (b[i].dl += (h * f) / u),
                                                (b[i].da += (d * f) / u),
                                                (b[i].db += (p * f) / u),
                                                (b[o].dl -= (h * f) / u),
                                                (b[o].da -= (d * f) / u),
                                                (b[o].db -= (p * f) / u))
                                              : ((b[o].dl += 2 - 4 * t()),
                                                (b[o].da += 2 - 4 * t()),
                                                (b[o].db += 2 - 4 * t()));
                                  for (i = 0; i < C; i++)
                                      (m = r[i]),
                                          (v =
                                              100 *
                                              Math.sqrt(
                                                  Math.pow(b[i].dl, 2) +
                                                      Math.pow(b[i].da, 2) +
                                                      Math.pow(b[i].db, 2)
                                              )) > 0 &&
                                              ((y =
                                                  (100 * Math.min(0.1, v)) / v),
                                              n(
                                                  l(
                                                      (g = [
                                                          m[0] + b[i].dl * y,
                                                          m[1] + b[i].da * y,
                                                          m[2] + b[i].db * y,
                                                      ])
                                                  ),
                                                  g
                                              ) && (r[i] = g));
                              }
                          })(i, m, y, v, e)
                        : (function (t, e, n, r) {
                              var s,
                                  i,
                                  o,
                                  a,
                                  c = [],
                                  u = [],
                                  h = 5,
                                  d = 10,
                                  p = 10;
                              for (
                                  r.ultraPrecision &&
                                      ((h = 1), (d = 5), (p = 5)),
                                      s = 0;
                                  s <= 100;
                                  s += h
                              )
                                  for (i = -100; i <= 100; i += d)
                                      for (o = -100; o <= 100; o += p)
                                          e(l((a = [s, i, o])), a) &&
                                              (c.push(a), u.push(null));
                              for (
                                  var f,
                                      g,
                                      m,
                                      y,
                                      v,
                                      b,
                                      w,
                                      C,
                                      x,
                                      _ = r.quality,
                                      k = c.length,
                                      A = n.length;
                                  _-- > 0;

                              ) {
                                  for (f = 0; f < k; f++)
                                      for (
                                          m = c[f], v = 1 / 0, g = 0;
                                          g < A;
                                          g++
                                      )
                                          (y = t(n[g], m)) < v &&
                                              ((v = y), (u[f] = g));
                                  for (b = c.slice(), g = 0; g < A; g++) {
                                      for (
                                          w = 0, C = [0, 0, 0], f = 0;
                                          f < k;
                                          f++
                                      )
                                          u[f] === g &&
                                              (w++,
                                              (C[0] += c[f][0]),
                                              (C[1] += c[f][1]),
                                              (C[2] += c[f][2]));
                                      if (0 !== w)
                                          if (
                                              ((C[0] /= w),
                                              (C[1] /= w),
                                              (C[2] /= w),
                                              e(l(C), C))
                                          )
                                              n[g] = C;
                                          else {
                                              if (b.length > 0) {
                                                  for (
                                                      v = 1 / 0, x = -1, f = 0;
                                                      f < b.length;
                                                      f++
                                                  )
                                                      (y = t(b[f], C)) < v &&
                                                          ((v = y), (x = f));
                                                  n[g] = c[x];
                                              } else {
                                                  for (
                                                      v = 1 / 0, x = -1, f = 0;
                                                      f < c.length;
                                                      f++
                                                  )
                                                      (y = t(c[f], C)) < v &&
                                                          ((v = y), (x = f));
                                                  n[g] = c[x];
                                              }
                                              b = b.filter(function (t) {
                                                  return (
                                                      t[0] !== n[g][0] ||
                                                      t[1] !== n[g][1] ||
                                                      t[2] !== n[g][2]
                                                  );
                                              });
                                          }
                                  }
                              }
                          })(m, y, v, e),
                    (v = h(m, v)).map(c)
                );
            };
        },
        0: function (t, e, n) {
            t.exports = n("7rdI");
        },
        "1Hq2": function (t, e, n) {
            "use strict";
            Object.defineProperty(e, "__esModule", { value: !0 }),
                (e.default = e.gtag = e.install = void 0),
                (e.install = function (t) {
                    if (!document.getElementById("ga-gtag")) {
                        var e = document.head,
                            n = document.createElement("script");
                        (n.id = "ga-gtag"),
                            (n.type = "text/javascript"),
                            (n.async = !0),
                            (n.src =
                                "https://www.googletagmanager.com/gtag/js?id=".concat(
                                    t
                                )),
                            e.insertBefore(n, e.firstChild),
                            (window.dataLayer = window.dataLayer || []),
                            r("js", new Date()),
                            r("config", t);
                    }
                });
            var r = function () {
                window.dataLayer.push(arguments);
            };
            (e.gtag = r), (e.default = r);
        },
        "7rdI": function (t, e, n) {
            "use strict";
            function r(t) {
                return "function" == typeof t;
            }
            n.r(e);
            let s = !1;
            const i = {
                Promise: void 0,
                set useDeprecatedSynchronousErrorHandling(t) {
                    if (t) {
                        const t = new Error();
                        console.warn(
                            "DEPRECATED! RxJS was set to use deprecated synchronous error handling behavior by code at: \n" +
                                t.stack
                        );
                    } else
                        s &&
                            console.log(
                                "RxJS: Back to a better error behavior. Thank you. <3"
                            );
                    s = t;
                },
                get useDeprecatedSynchronousErrorHandling() {
                    return s;
                },
            };
            function o(t) {
                setTimeout(() => {
                    throw t;
                }, 0);
            }
            const a = {
                    closed: !0,
                    next(t) {},
                    error(t) {
                        if (i.useDeprecatedSynchronousErrorHandling) throw t;
                        o(t);
                    },
                    complete() {},
                },
                l = (() =>
                    Array.isArray ||
                    ((t) => t && "number" == typeof t.length))();
            function c(t) {
                return null !== t && "object" == typeof t;
            }
            const u = (() => {
                function t(t) {
                    return (
                        Error.call(this),
                        (this.message = t
                            ? `${
                                  t.length
                              } errors occurred during unsubscription:\n${t
                                  .map((t, e) => `${e + 1}) ${t.toString()}`)
                                  .join("\n  ")}`
                            : ""),
                        (this.name = "UnsubscriptionError"),
                        (this.errors = t),
                        this
                    );
                }
                return (t.prototype = Object.create(Error.prototype)), t;
            })();
            let h = (() => {
                class t {
                    constructor(t) {
                        (this.closed = !1),
                            (this._parentOrParents = null),
                            (this._subscriptions = null),
                            t &&
                                ((this._ctorUnsubscribe = !0),
                                (this._unsubscribe = t));
                    }
                    unsubscribe() {
                        let e;
                        if (this.closed) return;
                        let {
                            _parentOrParents: n,
                            _ctorUnsubscribe: s,
                            _unsubscribe: i,
                            _subscriptions: o,
                        } = this;
                        if (
                            ((this.closed = !0),
                            (this._parentOrParents = null),
                            (this._subscriptions = null),
                            n instanceof t)
                        )
                            n.remove(this);
                        else if (null !== n)
                            for (let t = 0; t < n.length; ++t)
                                n[t].remove(this);
                        if (r(i)) {
                            s && (this._unsubscribe = void 0);
                            try {
                                i.call(this);
                            } catch (a) {
                                e = a instanceof u ? d(a.errors) : [a];
                            }
                        }
                        if (l(o)) {
                            let t = -1,
                                n = o.length;
                            for (; ++t < n; ) {
                                const n = o[t];
                                if (c(n))
                                    try {
                                        n.unsubscribe();
                                    } catch (a) {
                                        (e = e || []),
                                            a instanceof u
                                                ? (e = e.concat(d(a.errors)))
                                                : e.push(a);
                                    }
                            }
                        }
                        if (e) throw new u(e);
                    }
                    add(e) {
                        let n = e;
                        if (!e) return t.EMPTY;
                        switch (typeof e) {
                            case "function":
                                n = new t(e);
                            case "object":
                                if (
                                    n === this ||
                                    n.closed ||
                                    "function" != typeof n.unsubscribe
                                )
                                    return n;
                                if (this.closed) return n.unsubscribe(), n;
                                if (!(n instanceof t)) {
                                    const e = n;
                                    (n = new t()), (n._subscriptions = [e]);
                                }
                                break;
                            default:
                                throw new Error(
                                    "unrecognized teardown " +
                                        e +
                                        " added to Subscription."
                                );
                        }
                        let { _parentOrParents: r } = n;
                        if (null === r) n._parentOrParents = this;
                        else if (r instanceof t) {
                            if (r === this) return n;
                            n._parentOrParents = [r, this];
                        } else {
                            if (-1 !== r.indexOf(this)) return n;
                            r.push(this);
                        }
                        const s = this._subscriptions;
                        return (
                            null === s
                                ? (this._subscriptions = [n])
                                : s.push(n),
                            n
                        );
                    }
                    remove(t) {
                        const e = this._subscriptions;
                        if (e) {
                            const n = e.indexOf(t);
                            -1 !== n && e.splice(n, 1);
                        }
                    }
                }
                return (
                    (t.EMPTY = (function (t) {
                        return (t.closed = !0), t;
                    })(new t())),
                    t
                );
            })();
            function d(t) {
                return t.reduce(
                    (t, e) => t.concat(e instanceof u ? e.errors : e),
                    []
                );
            }
            const p = (() =>
                "function" == typeof Symbol
                    ? Symbol("rxSubscriber")
                    : "@@rxSubscriber_" + Math.random())();
            class f extends h {
                constructor(t, e, n) {
                    switch (
                        (super(),
                        (this.syncErrorValue = null),
                        (this.syncErrorThrown = !1),
                        (this.syncErrorThrowable = !1),
                        (this.isStopped = !1),
                        arguments.length)
                    ) {
                        case 0:
                            this.destination = a;
                            break;
                        case 1:
                            if (!t) {
                                this.destination = a;
                                break;
                            }
                            if ("object" == typeof t) {
                                t instanceof f
                                    ? ((this.syncErrorThrowable =
                                          t.syncErrorThrowable),
                                      (this.destination = t),
                                      t.add(this))
                                    : ((this.syncErrorThrowable = !0),
                                      (this.destination = new g(this, t)));
                                break;
                            }
                        default:
                            (this.syncErrorThrowable = !0),
                                (this.destination = new g(this, t, e, n));
                    }
                }
                [p]() {
                    return this;
                }
                static create(t, e, n) {
                    const r = new f(t, e, n);
                    return (r.syncErrorThrowable = !1), r;
                }
                next(t) {
                    this.isStopped || this._next(t);
                }
                error(t) {
                    this.isStopped || ((this.isStopped = !0), this._error(t));
                }
                complete() {
                    this.isStopped || ((this.isStopped = !0), this._complete());
                }
                unsubscribe() {
                    this.closed || ((this.isStopped = !0), super.unsubscribe());
                }
                _next(t) {
                    this.destination.next(t);
                }
                _error(t) {
                    this.destination.error(t), this.unsubscribe();
                }
                _complete() {
                    this.destination.complete(), this.unsubscribe();
                }
                _unsubscribeAndRecycle() {
                    const { _parentOrParents: t } = this;
                    return (
                        (this._parentOrParents = null),
                        this.unsubscribe(),
                        (this.closed = !1),
                        (this.isStopped = !1),
                        (this._parentOrParents = t),
                        this
                    );
                }
            }
            class g extends f {
                constructor(t, e, n, s) {
                    let i;
                    super(), (this._parentSubscriber = t);
                    let o = this;
                    r(e)
                        ? (i = e)
                        : e &&
                          ((i = e.next),
                          (n = e.error),
                          (s = e.complete),
                          e !== a &&
                              ((o = Object.create(e)),
                              r(o.unsubscribe) &&
                                  this.add(o.unsubscribe.bind(o)),
                              (o.unsubscribe = this.unsubscribe.bind(this)))),
                        (this._context = o),
                        (this._next = i),
                        (this._error = n),
                        (this._complete = s);
                }
                next(t) {
                    if (!this.isStopped && this._next) {
                        const { _parentSubscriber: e } = this;
                        i.useDeprecatedSynchronousErrorHandling &&
                        e.syncErrorThrowable
                            ? this.__tryOrSetError(e, this._next, t) &&
                              this.unsubscribe()
                            : this.__tryOrUnsub(this._next, t);
                    }
                }
                error(t) {
                    if (!this.isStopped) {
                        const { _parentSubscriber: e } = this,
                            { useDeprecatedSynchronousErrorHandling: n } = i;
                        if (this._error)
                            n && e.syncErrorThrowable
                                ? (this.__tryOrSetError(e, this._error, t),
                                  this.unsubscribe())
                                : (this.__tryOrUnsub(this._error, t),
                                  this.unsubscribe());
                        else if (e.syncErrorThrowable)
                            n
                                ? ((e.syncErrorValue = t),
                                  (e.syncErrorThrown = !0))
                                : o(t),
                                this.unsubscribe();
                        else {
                            if ((this.unsubscribe(), n)) throw t;
                            o(t);
                        }
                    }
                }
                complete() {
                    if (!this.isStopped) {
                        const { _parentSubscriber: t } = this;
                        if (this._complete) {
                            const e = () => this._complete.call(this._context);
                            i.useDeprecatedSynchronousErrorHandling &&
                            t.syncErrorThrowable
                                ? (this.__tryOrSetError(t, e),
                                  this.unsubscribe())
                                : (this.__tryOrUnsub(e), this.unsubscribe());
                        } else this.unsubscribe();
                    }
                }
                __tryOrUnsub(t, e) {
                    try {
                        t.call(this._context, e);
                    } catch (n) {
                        if (
                            (this.unsubscribe(),
                            i.useDeprecatedSynchronousErrorHandling)
                        )
                            throw n;
                        o(n);
                    }
                }
                __tryOrSetError(t, e, n) {
                    if (!i.useDeprecatedSynchronousErrorHandling)
                        throw new Error("bad call");
                    try {
                        e.call(this._context, n);
                    } catch (r) {
                        return i.useDeprecatedSynchronousErrorHandling
                            ? ((t.syncErrorValue = r),
                              (t.syncErrorThrown = !0),
                              !0)
                            : (o(r), !0);
                    }
                    return !1;
                }
                _unsubscribe() {
                    const { _parentSubscriber: t } = this;
                    (this._context = null),
                        (this._parentSubscriber = null),
                        t.unsubscribe();
                }
            }
            const m = (() =>
                ("function" == typeof Symbol && Symbol.observable) ||
                "@@observable")();
            function y(t) {
                return t;
            }
            let v = (() => {
                class t {
                    constructor(t) {
                        (this._isScalar = !1), t && (this._subscribe = t);
                    }
                    lift(e) {
                        const n = new t();
                        return (n.source = this), (n.operator = e), n;
                    }
                    subscribe(t, e, n) {
                        const { operator: r } = this,
                            s = (function (t, e, n) {
                                if (t) {
                                    if (t instanceof f) return t;
                                    if (t[p]) return t[p]();
                                }
                                return t || e || n ? new f(t, e, n) : new f(a);
                            })(t, e, n);
                        if (
                            (s.add(
                                r
                                    ? r.call(s, this.source)
                                    : this.source ||
                                      (i.useDeprecatedSynchronousErrorHandling &&
                                          !s.syncErrorThrowable)
                                    ? this._subscribe(s)
                                    : this._trySubscribe(s)
                            ),
                            i.useDeprecatedSynchronousErrorHandling &&
                                s.syncErrorThrowable &&
                                ((s.syncErrorThrowable = !1),
                                s.syncErrorThrown))
                        )
                            throw s.syncErrorValue;
                        return s;
                    }
                    _trySubscribe(t) {
                        try {
                            return this._subscribe(t);
                        } catch (e) {
                            i.useDeprecatedSynchronousErrorHandling &&
                                ((t.syncErrorThrown = !0),
                                (t.syncErrorValue = e)),
                                (function (t) {
                                    for (; t; ) {
                                        const {
                                            closed: e,
                                            destination: n,
                                            isStopped: r,
                                        } = t;
                                        if (e || r) return !1;
                                        t = n && n instanceof f ? n : null;
                                    }
                                    return !0;
                                })(t)
                                    ? t.error(e)
                                    : console.warn(e);
                        }
                    }
                    forEach(t, e) {
                        return new (e = b(e))((e, n) => {
                            let r;
                            r = this.subscribe(
                                (e) => {
                                    try {
                                        t(e);
                                    } catch (s) {
                                        n(s), r && r.unsubscribe();
                                    }
                                },
                                n,
                                e
                            );
                        });
                    }
                    _subscribe(t) {
                        const { source: e } = this;
                        return e && e.subscribe(t);
                    }
                    [m]() {
                        return this;
                    }
                    pipe(...t) {
                        return 0 === t.length
                            ? this
                            : (0 === (e = t).length
                                  ? y
                                  : 1 === e.length
                                  ? e[0]
                                  : function (t) {
                                        return e.reduce((t, e) => e(t), t);
                                    })(this);
                        var e;
                    }
                    toPromise(t) {
                        return new (t = b(t))((t, e) => {
                            let n;
                            this.subscribe(
                                (t) => (n = t),
                                (t) => e(t),
                                () => t(n)
                            );
                        });
                    }
                }
                return (t.create = (e) => new t(e)), t;
            })();
            function b(t) {
                if ((t || (t = i.Promise || Promise), !t))
                    throw new Error("no Promise impl found");
                return t;
            }
            const w = (() => {
                function t() {
                    return (
                        Error.call(this),
                        (this.message = "object unsubscribed"),
                        (this.name = "ObjectUnsubscribedError"),
                        this
                    );
                }
                return (t.prototype = Object.create(Error.prototype)), t;
            })();
            class C extends h {
                constructor(t, e) {
                    super(),
                        (this.subject = t),
                        (this.subscriber = e),
                        (this.closed = !1);
                }
                unsubscribe() {
                    if (this.closed) return;
                    this.closed = !0;
                    const t = this.subject,
                        e = t.observers;
                    if (
                        ((this.subject = null),
                        !e || 0 === e.length || t.isStopped || t.closed)
                    )
                        return;
                    const n = e.indexOf(this.subscriber);
                    -1 !== n && e.splice(n, 1);
                }
            }
            class x extends f {
                constructor(t) {
                    super(t), (this.destination = t);
                }
            }
            let _ = (() => {
                class t extends v {
                    constructor() {
                        super(),
                            (this.observers = []),
                            (this.closed = !1),
                            (this.isStopped = !1),
                            (this.hasError = !1),
                            (this.thrownError = null);
                    }
                    [p]() {
                        return new x(this);
                    }
                    lift(t) {
                        const e = new k(this, this);
                        return (e.operator = t), e;
                    }
                    next(t) {
                        if (this.closed) throw new w();
                        if (!this.isStopped) {
                            const { observers: e } = this,
                                n = e.length,
                                r = e.slice();
                            for (let s = 0; s < n; s++) r[s].next(t);
                        }
                    }
                    error(t) {
                        if (this.closed) throw new w();
                        (this.hasError = !0),
                            (this.thrownError = t),
                            (this.isStopped = !0);
                        const { observers: e } = this,
                            n = e.length,
                            r = e.slice();
                        for (let s = 0; s < n; s++) r[s].error(t);
                        this.observers.length = 0;
                    }
                    complete() {
                        if (this.closed) throw new w();
                        this.isStopped = !0;
                        const { observers: t } = this,
                            e = t.length,
                            n = t.slice();
                        for (let r = 0; r < e; r++) n[r].complete();
                        this.observers.length = 0;
                    }
                    unsubscribe() {
                        (this.isStopped = !0),
                            (this.closed = !0),
                            (this.observers = null);
                    }
                    _trySubscribe(t) {
                        if (this.closed) throw new w();
                        return super._trySubscribe(t);
                    }
                    _subscribe(t) {
                        if (this.closed) throw new w();
                        return this.hasError
                            ? (t.error(this.thrownError), h.EMPTY)
                            : this.isStopped
                            ? (t.complete(), h.EMPTY)
                            : (this.observers.push(t), new C(this, t));
                    }
                    asObservable() {
                        const t = new v();
                        return (t.source = this), t;
                    }
                }
                return (t.create = (t, e) => new k(t, e)), t;
            })();
            class k extends _ {
                constructor(t, e) {
                    super(), (this.destination = t), (this.source = e);
                }
                next(t) {
                    const { destination: e } = this;
                    e && e.next && e.next(t);
                }
                error(t) {
                    const { destination: e } = this;
                    e && e.error && this.destination.error(t);
                }
                complete() {
                    const { destination: t } = this;
                    t && t.complete && this.destination.complete();
                }
                _subscribe(t) {
                    const { source: e } = this;
                    return e ? this.source.subscribe(t) : h.EMPTY;
                }
            }
            function A(t) {
                return t && "function" == typeof t.schedule;
            }
            function E(t, e) {
                return function (n) {
                    if ("function" != typeof t)
                        throw new TypeError(
                            "argument is not a function. Are you looking for `mapTo()`?"
                        );
                    return n.lift(new I(t, e));
                };
            }
            class I {
                constructor(t, e) {
                    (this.project = t), (this.thisArg = e);
                }
                call(t, e) {
                    return e.subscribe(new T(t, this.project, this.thisArg));
                }
            }
            class T extends f {
                constructor(t, e, n) {
                    super(t),
                        (this.project = e),
                        (this.count = 0),
                        (this.thisArg = n || this);
                }
                _next(t) {
                    let e;
                    try {
                        e = this.project.call(this.thisArg, t, this.count++);
                    } catch (n) {
                        return void this.destination.error(n);
                    }
                    this.destination.next(e);
                }
            }
            const S = (t) => (e) => {
                for (let n = 0, r = t.length; n < r && !e.closed; n++)
                    e.next(t[n]);
                e.complete();
            };
            function O() {
                return "function" == typeof Symbol && Symbol.iterator
                    ? Symbol.iterator
                    : "@@iterator";
            }
            const M = O(),
                P = (t) =>
                    t && "number" == typeof t.length && "function" != typeof t;
            function R(t) {
                return (
                    !!t &&
                    "function" != typeof t.subscribe &&
                    "function" == typeof t.then
                );
            }
            const N = (t) => {
                if (t && "function" == typeof t[m])
                    return (
                        (r = t),
                        (t) => {
                            const e = r[m]();
                            if ("function" != typeof e.subscribe)
                                throw new TypeError(
                                    "Provided object does not correctly implement Symbol.observable"
                                );
                            return e.subscribe(t);
                        }
                    );
                if (P(t)) return S(t);
                if (R(t))
                    return (
                        (n = t),
                        (t) => (
                            n
                                .then(
                                    (e) => {
                                        t.closed || (t.next(e), t.complete());
                                    },
                                    (e) => t.error(e)
                                )
                                .then(null, o),
                            t
                        )
                    );
                if (t && "function" == typeof t[M])
                    return (
                        (e = t),
                        (t) => {
                            const n = e[M]();
                            for (;;) {
                                let e;
                                try {
                                    e = n.next();
                                } catch (r) {
                                    return t.error(r), t;
                                }
                                if (e.done) {
                                    t.complete();
                                    break;
                                }
                                if ((t.next(e.value), t.closed)) break;
                            }
                            return (
                                "function" == typeof n.return &&
                                    t.add(() => {
                                        n.return && n.return();
                                    }),
                                t
                            );
                        }
                    );
                {
                    const e = c(t) ? "an invalid object" : `'${t}'`;
                    throw new TypeError(
                        `You provided ${e} where a stream was expected. You can provide an Observable, Promise, Array, or Iterable.`
                    );
                }
                var e, n, r;
            };
            function D(t, e) {
                return new v((n) => {
                    const r = new h();
                    let s = 0;
                    return (
                        r.add(
                            e.schedule(function () {
                                s !== t.length
                                    ? (n.next(t[s++]),
                                      n.closed || r.add(this.schedule()))
                                    : n.complete();
                            })
                        ),
                        r
                    );
                });
            }
            function V(t, e) {
                return e
                    ? (function (t, e) {
                          if (null != t) {
                              if (
                                  (function (t) {
                                      return t && "function" == typeof t[m];
                                  })(t)
                              )
                                  return (function (t, e) {
                                      return new v((n) => {
                                          const r = new h();
                                          return (
                                              r.add(
                                                  e.schedule(() => {
                                                      const s = t[m]();
                                                      r.add(
                                                          s.subscribe({
                                                              next(t) {
                                                                  r.add(
                                                                      e.schedule(
                                                                          () =>
                                                                              n.next(
                                                                                  t
                                                                              )
                                                                      )
                                                                  );
                                                              },
                                                              error(t) {
                                                                  r.add(
                                                                      e.schedule(
                                                                          () =>
                                                                              n.error(
                                                                                  t
                                                                              )
                                                                      )
                                                                  );
                                                              },
                                                              complete() {
                                                                  r.add(
                                                                      e.schedule(
                                                                          () =>
                                                                              n.complete()
                                                                      )
                                                                  );
                                                              },
                                                          })
                                                      );
                                                  })
                                              ),
                                              r
                                          );
                                      });
                                  })(t, e);
                              if (R(t))
                                  return (function (t, e) {
                                      return new v((n) => {
                                          const r = new h();
                                          return (
                                              r.add(
                                                  e.schedule(() =>
                                                      t.then(
                                                          (t) => {
                                                              r.add(
                                                                  e.schedule(
                                                                      () => {
                                                                          n.next(
                                                                              t
                                                                          ),
                                                                              r.add(
                                                                                  e.schedule(
                                                                                      () =>
                                                                                          n.complete()
                                                                                  )
                                                                              );
                                                                      }
                                                                  )
                                                              );
                                                          },
                                                          (t) => {
                                                              r.add(
                                                                  e.schedule(
                                                                      () =>
                                                                          n.error(
                                                                              t
                                                                          )
                                                                  )
                                                              );
                                                          }
                                                      )
                                                  )
                                              ),
                                              r
                                          );
                                      });
                                  })(t, e);
                              if (P(t)) return D(t, e);
                              if (
                                  (function (t) {
                                      return t && "function" == typeof t[M];
                                  })(t) ||
                                  "string" == typeof t
                              )
                                  return (function (t, e) {
                                      if (!t)
                                          throw new Error(
                                              "Iterable cannot be null"
                                          );
                                      return new v((n) => {
                                          const r = new h();
                                          let s;
                                          return (
                                              r.add(() => {
                                                  s &&
                                                      "function" ==
                                                          typeof s.return &&
                                                      s.return();
                                              }),
                                              r.add(
                                                  e.schedule(() => {
                                                      (s = t[M]()),
                                                          r.add(
                                                              e.schedule(
                                                                  function () {
                                                                      if (
                                                                          n.closed
                                                                      )
                                                                          return;
                                                                      let t, e;
                                                                      try {
                                                                          const n =
                                                                              s.next();
                                                                          (t =
                                                                              n.value),
                                                                              (e =
                                                                                  n.done);
                                                                      } catch (r) {
                                                                          return void n.error(
                                                                              r
                                                                          );
                                                                      }
                                                                      e
                                                                          ? n.complete()
                                                                          : (n.next(
                                                                                t
                                                                            ),
                                                                            this.schedule());
                                                                  }
                                                              )
                                                          );
                                                  })
                                              ),
                                              r
                                          );
                                      });
                                  })(t, e);
                          }
                          throw new TypeError(
                              ((null !== t && typeof t) || t) +
                                  " is not observable"
                          );
                      })(t, e)
                    : t instanceof v
                    ? t
                    : new v(N(t));
            }
            class F extends f {
                constructor(t) {
                    super(), (this.parent = t);
                }
                _next(t) {
                    this.parent.notifyNext(t);
                }
                _error(t) {
                    this.parent.notifyError(t), this.unsubscribe();
                }
                _complete() {
                    this.parent.notifyComplete(), this.unsubscribe();
                }
            }
            class j extends f {
                notifyNext(t) {
                    this.destination.next(t);
                }
                notifyError(t) {
                    this.destination.error(t);
                }
                notifyComplete() {
                    this.destination.complete();
                }
            }
            function z(t, e) {
                if (!e.closed) return t instanceof v ? t.subscribe(e) : N(t)(e);
            }
            function B(t, e, n = Number.POSITIVE_INFINITY) {
                return "function" == typeof e
                    ? (r) =>
                          r.pipe(
                              B(
                                  (n, r) =>
                                      V(t(n, r)).pipe(
                                          E((t, s) => e(n, t, r, s))
                                      ),
                                  n
                              )
                          )
                    : ("number" == typeof e && (n = e),
                      (e) => e.lift(new H(t, n)));
            }
            class H {
                constructor(t, e = Number.POSITIVE_INFINITY) {
                    (this.project = t), (this.concurrent = e);
                }
                call(t, e) {
                    return e.subscribe(new L(t, this.project, this.concurrent));
                }
            }
            class L extends j {
                constructor(t, e, n = Number.POSITIVE_INFINITY) {
                    super(t),
                        (this.project = e),
                        (this.concurrent = n),
                        (this.hasCompleted = !1),
                        (this.buffer = []),
                        (this.active = 0),
                        (this.index = 0);
                }
                _next(t) {
                    this.active < this.concurrent
                        ? this._tryNext(t)
                        : this.buffer.push(t);
                }
                _tryNext(t) {
                    let e;
                    const n = this.index++;
                    try {
                        e = this.project(t, n);
                    } catch (r) {
                        return void this.destination.error(r);
                    }
                    this.active++, this._innerSub(e);
                }
                _innerSub(t) {
                    const e = new F(this),
                        n = this.destination;
                    n.add(e);
                    const r = z(t, e);
                    r !== e && n.add(r);
                }
                _complete() {
                    (this.hasCompleted = !0),
                        0 === this.active &&
                            0 === this.buffer.length &&
                            this.destination.complete(),
                        this.unsubscribe();
                }
                notifyNext(t) {
                    this.destination.next(t);
                }
                notifyComplete() {
                    const t = this.buffer;
                    this.active--,
                        t.length > 0
                            ? this._next(t.shift())
                            : 0 === this.active &&
                              this.hasCompleted &&
                              this.destination.complete();
                }
            }
            function q(t, e) {
                return e ? D(t, e) : new v(S(t));
            }
            function K(...t) {
                let e = Number.POSITIVE_INFINITY,
                    n = null,
                    r = t[t.length - 1];
                return (
                    A(r)
                        ? ((n = t.pop()),
                          t.length > 1 &&
                              "number" == typeof t[t.length - 1] &&
                              (e = t.pop()))
                        : "number" == typeof r && (e = t.pop()),
                    null === n && 1 === t.length && t[0] instanceof v
                        ? t[0]
                        : (function (t = Number.POSITIVE_INFINITY) {
                              return B(y, t);
                          })(e)(q(t, n))
                );
            }
            function W() {
                return function (t) {
                    return t.lift(new U(t));
                };
            }
            class U {
                constructor(t) {
                    this.connectable = t;
                }
                call(t, e) {
                    const { connectable: n } = this;
                    n._refCount++;
                    const r = new Z(t, n),
                        s = e.subscribe(r);
                    return r.closed || (r.connection = n.connect()), s;
                }
            }
            class Z extends f {
                constructor(t, e) {
                    super(t), (this.connectable = e);
                }
                _unsubscribe() {
                    const { connectable: t } = this;
                    if (!t) return void (this.connection = null);
                    this.connectable = null;
                    const e = t._refCount;
                    if (e <= 0) return void (this.connection = null);
                    if (((t._refCount = e - 1), e > 1))
                        return void (this.connection = null);
                    const { connection: n } = this,
                        r = t._connection;
                    (this.connection = null),
                        !r || (n && r !== n) || r.unsubscribe();
                }
            }
            class Y extends v {
                constructor(t, e) {
                    super(),
                        (this.source = t),
                        (this.subjectFactory = e),
                        (this._refCount = 0),
                        (this._isComplete = !1);
                }
                _subscribe(t) {
                    return this.getSubject().subscribe(t);
                }
                getSubject() {
                    const t = this._subject;
                    return (
                        (t && !t.isStopped) ||
                            (this._subject = this.subjectFactory()),
                        this._subject
                    );
                }
                connect() {
                    let t = this._connection;
                    return (
                        t ||
                            ((this._isComplete = !1),
                            (t = this._connection = new h()),
                            t.add(
                                this.source.subscribe(
                                    new X(this.getSubject(), this)
                                )
                            ),
                            t.closed &&
                                ((this._connection = null), (t = h.EMPTY))),
                        t
                    );
                }
                refCount() {
                    return W()(this);
                }
            }
            const G = (() => {
                const t = Y.prototype;
                return {
                    operator: { value: null },
                    _refCount: { value: 0, writable: !0 },
                    _subject: { value: null, writable: !0 },
                    _connection: { value: null, writable: !0 },
                    _subscribe: { value: t._subscribe },
                    _isComplete: { value: t._isComplete, writable: !0 },
                    getSubject: { value: t.getSubject },
                    connect: { value: t.connect },
                    refCount: { value: t.refCount },
                };
            })();
            class X extends x {
                constructor(t, e) {
                    super(t), (this.connectable = e);
                }
                _error(t) {
                    this._unsubscribe(), super._error(t);
                }
                _complete() {
                    (this.connectable._isComplete = !0),
                        this._unsubscribe(),
                        super._complete();
                }
                _unsubscribe() {
                    const t = this.connectable;
                    if (t) {
                        this.connectable = null;
                        const e = t._connection;
                        (t._refCount = 0),
                            (t._subject = null),
                            (t._connection = null),
                            e && e.unsubscribe();
                    }
                }
            }
            function J() {
                return new _();
            }
            function Q(t) {
                for (let e in t) if (t[e] === Q) return e;
                throw Error(
                    "Could not find renamed property on target object."
                );
            }
            function $(t) {
                if ("string" == typeof t) return t;
                if (Array.isArray(t)) return "[" + t.map($).join(", ") + "]";
                if (null == t) return "" + t;
                if (t.overriddenName) return `${t.overriddenName}`;
                if (t.name) return `${t.name}`;
                const e = t.toString();
                if (null == e) return "" + e;
                const n = e.indexOf("\n");
                return -1 === n ? e : e.substring(0, n);
            }
            function tt(t, e) {
                return null == t || "" === t
                    ? null === e
                        ? ""
                        : e
                    : null == e || "" === e
                    ? t
                    : t + " " + e;
            }
            const et = Q({ __forward_ref__: Q });
            function nt(t) {
                return (
                    (t.__forward_ref__ = nt),
                    (t.toString = function () {
                        return $(this());
                    }),
                    t
                );
            }
            function rt(t) {
                return "function" == typeof (e = t) &&
                    e.hasOwnProperty(et) &&
                    e.__forward_ref__ === nt
                    ? t()
                    : t;
                var e;
            }
            function st(t) {
                return {
                    token: t.token,
                    providedIn: t.providedIn || null,
                    factory: t.factory,
                    value: void 0,
                };
            }
            function it(t) {
                return {
                    factory: t.factory,
                    providers: t.providers || [],
                    imports: t.imports || [],
                };
            }
            function ot(t) {
                return at(t, ct) || at(t, ht);
            }
            function at(t, e) {
                return t.hasOwnProperty(e) ? t[e] : null;
            }
            function lt(t) {
                return t && (t.hasOwnProperty(ut) || t.hasOwnProperty(dt))
                    ? t[ut]
                    : null;
            }
            const ct = Q({ "\u0275prov": Q }),
                ut = Q({ "\u0275inj": Q }),
                ht = Q({ ngInjectableDef: Q }),
                dt = Q({ ngInjectorDef: Q });
            var pt = (function (t) {
                return (
                    (t[(t.Default = 0)] = "Default"),
                    (t[(t.Host = 1)] = "Host"),
                    (t[(t.Self = 2)] = "Self"),
                    (t[(t.SkipSelf = 4)] = "SkipSelf"),
                    (t[(t.Optional = 8)] = "Optional"),
                    t
                );
            })({});
            let ft;
            function gt(t) {
                const e = ft;
                return (ft = t), e;
            }
            function mt(t, e, n) {
                const r = ot(t);
                if (r && "root" == r.providedIn)
                    return void 0 === r.value
                        ? (r.value = r.factory())
                        : r.value;
                if (n & pt.Optional) return null;
                if (void 0 !== e) return e;
                throw new Error(`Injector: NOT_FOUND [${$(t)}]`);
            }
            function yt(t) {
                return { toString: t }.toString();
            }
            var vt = (function (t) {
                    return (
                        (t[(t.OnPush = 0)] = "OnPush"),
                        (t[(t.Default = 1)] = "Default"),
                        t
                    );
                })({}),
                bt = (function (t) {
                    return (
                        (t[(t.Emulated = 0)] = "Emulated"),
                        (t[(t.None = 2)] = "None"),
                        (t[(t.ShadowDom = 3)] = "ShadowDom"),
                        t
                    );
                })({});
            const wt = "undefined" != typeof globalThis && globalThis,
                Ct = "undefined" != typeof window && window,
                xt =
                    "undefined" != typeof self &&
                    "undefined" != typeof WorkerGlobalScope &&
                    self instanceof WorkerGlobalScope &&
                    self,
                _t = "undefined" != typeof global && global,
                kt = wt || _t || Ct || xt,
                At = {},
                Et = [],
                It = Q({ "\u0275cmp": Q }),
                Tt = Q({ "\u0275dir": Q }),
                St = Q({ "\u0275pipe": Q }),
                Ot = Q({ "\u0275mod": Q }),
                Mt = Q({ "\u0275loc": Q }),
                Pt = Q({ "\u0275fac": Q }),
                Rt = Q({ __NG_ELEMENT_ID__: Q });
            let Nt = 0;
            function Dt(t) {
                return yt(() => {
                    const e = {},
                        n = {
                            type: t.type,
                            providersResolver: null,
                            decls: t.decls,
                            vars: t.vars,
                            factory: null,
                            template: t.template || null,
                            consts: t.consts || null,
                            ngContentSelectors: t.ngContentSelectors,
                            hostBindings: t.hostBindings || null,
                            hostVars: t.hostVars || 0,
                            hostAttrs: t.hostAttrs || null,
                            contentQueries: t.contentQueries || null,
                            declaredInputs: e,
                            inputs: null,
                            outputs: null,
                            exportAs: t.exportAs || null,
                            onPush: t.changeDetection === vt.OnPush,
                            directiveDefs: null,
                            pipeDefs: null,
                            selectors: t.selectors || Et,
                            viewQuery: t.viewQuery || null,
                            features: t.features || null,
                            data: t.data || {},
                            encapsulation: t.encapsulation || bt.Emulated,
                            id: "c",
                            styles: t.styles || Et,
                            _: null,
                            setInput: null,
                            schemas: t.schemas || null,
                            tView: null,
                        },
                        r = t.directives,
                        s = t.features,
                        i = t.pipes;
                    return (
                        (n.id += Nt++),
                        (n.inputs = Bt(t.inputs, e)),
                        (n.outputs = Bt(t.outputs)),
                        s && s.forEach((t) => t(n)),
                        (n.directiveDefs = r
                            ? () => ("function" == typeof r ? r() : r).map(Vt)
                            : null),
                        (n.pipeDefs = i
                            ? () => ("function" == typeof i ? i() : i).map(Ft)
                            : null),
                        n
                    );
                });
            }
            function Vt(t) {
                return (
                    Lt(t) ||
                    (function (t) {
                        return t[Tt] || null;
                    })(t)
                );
            }
            function Ft(t) {
                return (function (t) {
                    return t[St] || null;
                })(t);
            }
            const jt = {};
            function zt(t) {
                const e = {
                    type: t.type,
                    bootstrap: t.bootstrap || Et,
                    declarations: t.declarations || Et,
                    imports: t.imports || Et,
                    exports: t.exports || Et,
                    transitiveCompileScopes: null,
                    schemas: t.schemas || null,
                    id: t.id || null,
                };
                return (
                    null != t.id &&
                        yt(() => {
                            jt[t.id] = t.type;
                        }),
                    e
                );
            }
            function Bt(t, e) {
                if (null == t) return At;
                const n = {};
                for (const r in t)
                    if (t.hasOwnProperty(r)) {
                        let s = t[r],
                            i = s;
                        Array.isArray(s) && ((i = s[1]), (s = s[0])),
                            (n[s] = r),
                            e && (e[s] = i);
                    }
                return n;
            }
            const Ht = Dt;
            function Lt(t) {
                return t[It] || null;
            }
            function qt(t, e) {
                const n = t[Ot] || null;
                if (!n && !0 === e)
                    throw new Error(
                        `Type ${$(t)} does not have '\u0275mod' property.`
                    );
                return n;
            }
            function Kt(t) {
                return Array.isArray(t) && "object" == typeof t[1];
            }
            function Wt(t) {
                return Array.isArray(t) && !0 === t[1];
            }
            function Ut(t) {
                return 0 != (8 & t.flags);
            }
            function Zt(t) {
                return 2 == (2 & t.flags);
            }
            function Yt(t) {
                return 1 == (1 & t.flags);
            }
            function Gt(t) {
                return null !== t.template;
            }
            function Xt(t, e) {
                return t.hasOwnProperty(Pt) ? t[Pt] : null;
            }
            class Jt extends Error {
                constructor(t, e) {
                    super(
                        (function (t, e) {
                            return `${t ? `NG0${t}: ` : ""}${e}`;
                        })(t, e)
                    ),
                        (this.code = t);
                }
            }
            function Qt(t) {
                return "string" == typeof t ? t : null == t ? "" : String(t);
            }
            function $t(t) {
                return "function" == typeof t
                    ? t.name || t.toString()
                    : "object" == typeof t &&
                      null != t &&
                      "function" == typeof t.type
                    ? t.type.name || t.type.toString()
                    : Qt(t);
            }
            function te(t, e) {
                const n = e ? ` in ${e}` : "";
                throw new Jt("201", `No provider for ${$t(t)} found${n}`);
            }
            class ee {
                constructor(t, e, n) {
                    (this.previousValue = t),
                        (this.currentValue = e),
                        (this.firstChange = n);
                }
                isFirstChange() {
                    return this.firstChange;
                }
            }
            function ne() {
                return re;
            }
            function re(t) {
                return t.type.prototype.ngOnChanges && (t.setInput = ie), se;
            }
            function se() {
                const t = oe(this),
                    e = null == t ? void 0 : t.current;
                if (e) {
                    const n = t.previous;
                    if (n === At) t.previous = e;
                    else for (let t in e) n[t] = e[t];
                    (t.current = null), this.ngOnChanges(e);
                }
            }
            function ie(t, e, n, r) {
                const s =
                        oe(t) ||
                        (function (t, e) {
                            return (t.__ngSimpleChanges__ = e);
                        })(t, { previous: At, current: null }),
                    i = s.current || (s.current = {}),
                    o = s.previous,
                    a = this.declaredInputs[n],
                    l = o[a];
                (i[a] = new ee(l && l.currentValue, e, o === At)), (t[r] = e);
            }
            function oe(t) {
                return t.__ngSimpleChanges__ || null;
            }
            let ae;
            function le() {
                return void 0 !== ae
                    ? ae
                    : "undefined" != typeof document
                    ? document
                    : void 0;
            }
            function ce(t) {
                return !!t.listen;
            }
            ne.ngInherit = !0;
            const ue = { createRenderer: (t, e) => le() };
            function he(t) {
                for (; Array.isArray(t); ) t = t[0];
                return t;
            }
            function de(t, e) {
                return he(e[t]);
            }
            function pe(t, e) {
                return he(e[t.index]);
            }
            function fe(t, e) {
                return t.data[e];
            }
            function ge(t, e) {
                const n = e[t];
                return Kt(n) ? n : n[0];
            }
            function me(t) {
                const e = (function (t) {
                    return t.__ngContext__ || null;
                })(t);
                return e ? (Array.isArray(e) ? e : e.lView) : null;
            }
            function ye(t) {
                return 4 == (4 & t[2]);
            }
            function ve(t) {
                return 128 == (128 & t[2]);
            }
            function be(t, e) {
                return null == e ? null : t[e];
            }
            function we(t) {
                t[18] = 0;
            }
            function Ce(t, e) {
                t[5] += e;
                let n = t,
                    r = t[3];
                for (
                    ;
                    null !== r &&
                    ((1 === e && 1 === n[5]) || (-1 === e && 0 === n[5]));

                )
                    (r[5] += e), (n = r), (r = r[3]);
            }
            const xe = {
                lFrame: We(null),
                bindingsEnabled: !0,
                isInCheckNoChangesMode: !1,
            };
            function _e() {
                return xe.bindingsEnabled;
            }
            function ke() {
                return xe.lFrame.lView;
            }
            function Ae() {
                return xe.lFrame.tView;
            }
            function Ee(t) {
                xe.lFrame.contextLView = t;
            }
            function Ie() {
                let t = Te();
                for (; null !== t && 64 === t.type; ) t = t.parent;
                return t;
            }
            function Te() {
                return xe.lFrame.currentTNode;
            }
            function Se(t, e) {
                const n = xe.lFrame;
                (n.currentTNode = t), (n.isParent = e);
            }
            function Oe() {
                return xe.lFrame.isParent;
            }
            function Me() {
                xe.lFrame.isParent = !1;
            }
            function Pe() {
                return xe.isInCheckNoChangesMode;
            }
            function Re(t) {
                xe.isInCheckNoChangesMode = t;
            }
            function Ne() {
                const t = xe.lFrame;
                let e = t.bindingRootIndex;
                return (
                    -1 === e &&
                        (e = t.bindingRootIndex = t.tView.bindingStartIndex),
                    e
                );
            }
            function De() {
                return xe.lFrame.bindingIndex++;
            }
            function Ve(t) {
                const e = xe.lFrame,
                    n = e.bindingIndex;
                return (e.bindingIndex = e.bindingIndex + t), n;
            }
            function Fe(t, e) {
                const n = xe.lFrame;
                (n.bindingIndex = n.bindingRootIndex = t), je(e);
            }
            function je(t) {
                xe.lFrame.currentDirectiveIndex = t;
            }
            function ze() {
                return xe.lFrame.currentQueryIndex;
            }
            function Be(t) {
                xe.lFrame.currentQueryIndex = t;
            }
            function He(t) {
                const e = t[1];
                return 2 === e.type ? e.declTNode : 1 === e.type ? t[6] : null;
            }
            function Le(t, e, n) {
                if (n & pt.SkipSelf) {
                    let r = e,
                        s = t;
                    for (
                        ;
                        (r = r.parent),
                            !(
                                null !== r ||
                                n & pt.Host ||
                                ((r = He(s)), null === r) ||
                                ((s = s[15]), 10 & r.type)
                            );

                    );
                    if (null === r) return !1;
                    (e = r), (t = s);
                }
                const r = (xe.lFrame = Ke());
                return (r.currentTNode = e), (r.lView = t), !0;
            }
            function qe(t) {
                const e = Ke(),
                    n = t[1];
                (xe.lFrame = e),
                    (e.currentTNode = n.firstChild),
                    (e.lView = t),
                    (e.tView = n),
                    (e.contextLView = t),
                    (e.bindingIndex = n.bindingStartIndex),
                    (e.inI18n = !1);
            }
            function Ke() {
                const t = xe.lFrame,
                    e = null === t ? null : t.child;
                return null === e ? We(t) : e;
            }
            function We(t) {
                const e = {
                    currentTNode: null,
                    isParent: !0,
                    lView: null,
                    tView: null,
                    selectedIndex: -1,
                    contextLView: null,
                    elementDepthCount: 0,
                    currentNamespace: null,
                    currentDirectiveIndex: -1,
                    bindingRootIndex: -1,
                    bindingIndex: -1,
                    currentQueryIndex: 0,
                    parent: t,
                    child: null,
                    inI18n: !1,
                };
                return null !== t && (t.child = e), e;
            }
            function Ue() {
                const t = xe.lFrame;
                return (
                    (xe.lFrame = t.parent),
                    (t.currentTNode = null),
                    (t.lView = null),
                    t
                );
            }
            const Ze = Ue;
            function Ye() {
                const t = Ue();
                (t.isParent = !0),
                    (t.tView = null),
                    (t.selectedIndex = -1),
                    (t.contextLView = null),
                    (t.elementDepthCount = 0),
                    (t.currentDirectiveIndex = -1),
                    (t.currentNamespace = null),
                    (t.bindingRootIndex = -1),
                    (t.bindingIndex = -1),
                    (t.currentQueryIndex = 0);
            }
            function Ge() {
                return xe.lFrame.selectedIndex;
            }
            function Xe(t) {
                xe.lFrame.selectedIndex = t;
            }
            function Je() {
                const t = xe.lFrame;
                return fe(t.tView, t.selectedIndex);
            }
            function Qe(t, e) {
                for (let n = e.directiveStart, r = e.directiveEnd; n < r; n++) {
                    const e = t.data[n].type.prototype,
                        {
                            ngAfterContentInit: r,
                            ngAfterContentChecked: s,
                            ngAfterViewInit: i,
                            ngAfterViewChecked: o,
                            ngOnDestroy: a,
                        } = e;
                    r && (t.contentHooks || (t.contentHooks = [])).push(-n, r),
                        s &&
                            ((t.contentHooks || (t.contentHooks = [])).push(
                                n,
                                s
                            ),
                            (
                                t.contentCheckHooks ||
                                (t.contentCheckHooks = [])
                            ).push(n, s)),
                        i && (t.viewHooks || (t.viewHooks = [])).push(-n, i),
                        o &&
                            ((t.viewHooks || (t.viewHooks = [])).push(n, o),
                            (t.viewCheckHooks || (t.viewCheckHooks = [])).push(
                                n,
                                o
                            )),
                        null != a &&
                            (t.destroyHooks || (t.destroyHooks = [])).push(
                                n,
                                a
                            );
                }
            }
            function $e(t, e, n) {
                nn(t, e, 3, n);
            }
            function tn(t, e, n, r) {
                (3 & t[2]) === n && nn(t, e, n, r);
            }
            function en(t, e) {
                let n = t[2];
                (3 & n) === e && ((n &= 2047), (n += 1), (t[2] = n));
            }
            function nn(t, e, n, r) {
                const s = null != r ? r : -1,
                    i = e.length - 1;
                let o = 0;
                for (let a = void 0 !== r ? 65535 & t[18] : 0; a < i; a++)
                    if ("number" == typeof e[a + 1]) {
                        if (((o = e[a]), null != r && o >= r)) break;
                    } else
                        e[a] < 0 && (t[18] += 65536),
                            (o < s || -1 == s) &&
                                (rn(t, n, e, a),
                                (t[18] = (4294901760 & t[18]) + a + 2)),
                            a++;
            }
            function rn(t, e, n, r) {
                const s = n[r] < 0,
                    i = n[r + 1],
                    o = t[s ? -n[r] : n[r]];
                s
                    ? t[2] >> 11 < t[18] >> 16 &&
                      (3 & t[2]) === e &&
                      ((t[2] += 2048), i.call(o))
                    : i.call(o);
            }
            class sn {
                constructor(t, e, n) {
                    (this.factory = t),
                        (this.resolving = !1),
                        (this.canSeeViewProviders = e),
                        (this.injectImpl = n);
                }
            }
            function on(t, e, n) {
                const r = ce(t);
                let s = 0;
                for (; s < n.length; ) {
                    const i = n[s];
                    if ("number" == typeof i) {
                        if (0 !== i) break;
                        s++;
                        const o = n[s++],
                            a = n[s++],
                            l = n[s++];
                        r
                            ? t.setAttribute(e, a, l, o)
                            : e.setAttributeNS(o, a, l);
                    } else {
                        const o = i,
                            a = n[++s];
                        an(o)
                            ? r && t.setProperty(e, o, a)
                            : r
                            ? t.setAttribute(e, o, a)
                            : e.setAttribute(o, a),
                            s++;
                    }
                }
                return s;
            }
            function an(t) {
                return 64 === t.charCodeAt(0);
            }
            function ln(t, e) {
                if (null === e || 0 === e.length);
                else if (null === t || 0 === t.length) t = e.slice();
                else {
                    let n = -1;
                    for (let r = 0; r < e.length; r++) {
                        const s = e[r];
                        "number" == typeof s
                            ? (n = s)
                            : 0 === n ||
                              cn(
                                  t,
                                  n,
                                  s,
                                  null,
                                  -1 === n || 2 === n ? e[++r] : null
                              );
                    }
                }
                return t;
            }
            function cn(t, e, n, r, s) {
                let i = 0,
                    o = t.length;
                if (-1 === e) o = -1;
                else
                    for (; i < t.length; ) {
                        const n = t[i++];
                        if ("number" == typeof n) {
                            if (n === e) {
                                o = -1;
                                break;
                            }
                            if (n > e) {
                                o = i - 1;
                                break;
                            }
                        }
                    }
                for (; i < t.length; ) {
                    const e = t[i];
                    if ("number" == typeof e) break;
                    if (e === n) {
                        if (null === r)
                            return void (null !== s && (t[i + 1] = s));
                        if (r === t[i + 1]) return void (t[i + 2] = s);
                    }
                    i++, null !== r && i++, null !== s && i++;
                }
                -1 !== o && (t.splice(o, 0, e), (i = o + 1)),
                    t.splice(i++, 0, n),
                    null !== r && t.splice(i++, 0, r),
                    null !== s && t.splice(i++, 0, s);
            }
            function un(t) {
                return -1 !== t;
            }
            function hn(t) {
                return 32767 & t;
            }
            function dn(t, e) {
                let n = t >> 16,
                    r = e;
                for (; n > 0; ) (r = r[15]), n--;
                return r;
            }
            let pn = !0;
            function fn(t) {
                const e = pn;
                return (pn = t), e;
            }
            let gn = 0;
            function mn(t, e) {
                const n = vn(t, e);
                if (-1 !== n) return n;
                const r = e[1];
                r.firstCreatePass &&
                    ((t.injectorIndex = e.length),
                    yn(r.data, t),
                    yn(e, null),
                    yn(r.blueprint, null));
                const s = bn(t, e),
                    i = t.injectorIndex;
                if (un(s)) {
                    const t = hn(s),
                        n = dn(s, e),
                        r = n[1].data;
                    for (let s = 0; s < 8; s++) e[i + s] = n[t + s] | r[t + s];
                }
                return (e[i + 8] = s), i;
            }
            function yn(t, e) {
                t.push(0, 0, 0, 0, 0, 0, 0, 0, e);
            }
            function vn(t, e) {
                return -1 === t.injectorIndex ||
                    (t.parent && t.parent.injectorIndex === t.injectorIndex) ||
                    null === e[t.injectorIndex + 8]
                    ? -1
                    : t.injectorIndex;
            }
            function bn(t, e) {
                if (t.parent && -1 !== t.parent.injectorIndex)
                    return t.parent.injectorIndex;
                let n = 0,
                    r = null,
                    s = e;
                for (; null !== s; ) {
                    const t = s[1],
                        e = t.type;
                    if (
                        ((r = 2 === e ? t.declTNode : 1 === e ? s[6] : null),
                        null === r)
                    )
                        return -1;
                    if ((n++, (s = s[15]), -1 !== r.injectorIndex))
                        return r.injectorIndex | (n << 16);
                }
                return -1;
            }
            function wn(t, e, n) {
                !(function (t, e, n) {
                    let r;
                    "string" == typeof n
                        ? (r = n.charCodeAt(0) || 0)
                        : n.hasOwnProperty(Rt) && (r = n[Rt]),
                        null == r && (r = n[Rt] = gn++);
                    const s = 255 & r;
                    e.data[t + (s >> 5)] |= 1 << s;
                })(t, e, n);
            }
            function Cn(t, e, n) {
                if (n & pt.Optional) return t;
                te(e, "NodeInjector");
            }
            function xn(t, e, n, r) {
                if (
                    (n & pt.Optional && void 0 === r && (r = null),
                    0 == (n & (pt.Self | pt.Host)))
                ) {
                    const s = t[9],
                        i = gt(void 0);
                    try {
                        return s
                            ? s.get(e, r, n & pt.Optional)
                            : mt(e, r, n & pt.Optional);
                    } finally {
                        gt(i);
                    }
                }
                return Cn(r, e, n);
            }
            function _n(t, e, n, r = pt.Default, s) {
                if (null !== t) {
                    const i = (function (t) {
                        if ("string" == typeof t) return t.charCodeAt(0) || 0;
                        const e = t.hasOwnProperty(Rt) ? t[Rt] : void 0;
                        return "number" == typeof e
                            ? e >= 0
                                ? 255 & e
                                : An
                            : e;
                    })(n);
                    if ("function" == typeof i) {
                        if (!Le(e, t, r))
                            return r & pt.Host ? Cn(s, n, r) : xn(e, n, r, s);
                        try {
                            const t = i();
                            if (null != t || r & pt.Optional) return t;
                            te(n);
                        } finally {
                            Ze();
                        }
                    } else if ("number" == typeof i) {
                        let s = null,
                            o = vn(t, e),
                            a = -1,
                            l = r & pt.Host ? e[16][6] : null;
                        for (
                            (-1 === o || r & pt.SkipSelf) &&
                            ((a = -1 === o ? bn(t, e) : e[o + 8]),
                            -1 !== a && On(r, !1)
                                ? ((s = e[1]), (o = hn(a)), (e = dn(a, e)))
                                : (o = -1));
                            -1 !== o;

                        ) {
                            const t = e[1];
                            if (Sn(i, o, t.data)) {
                                const t = En(o, e, n, s, r, l);
                                if (t !== kn) return t;
                            }
                            (a = e[o + 8]),
                                -1 !== a &&
                                On(r, e[1].data[o + 8] === l) &&
                                Sn(i, o, e)
                                    ? ((s = t), (o = hn(a)), (e = dn(a, e)))
                                    : (o = -1);
                        }
                    }
                }
                return xn(e, n, r, s);
            }
            const kn = {};
            function An() {
                return new Mn(Ie(), ke());
            }
            function En(t, e, n, r, s, i) {
                const o = e[1],
                    a = o.data[t + 8],
                    l = In(
                        a,
                        o,
                        n,
                        null == r ? Zt(a) && pn : r != o && 0 != (3 & a.type),
                        s & pt.Host && i === a
                    );
                return null !== l ? Tn(e, o, l, a) : kn;
            }
            function In(t, e, n, r, s) {
                const i = t.providerIndexes,
                    o = e.data,
                    a = 1048575 & i,
                    l = t.directiveStart,
                    c = i >> 20,
                    u = s ? a + c : t.directiveEnd;
                for (let h = r ? a : a + c; h < u; h++) {
                    const t = o[h];
                    if ((h < l && n === t) || (h >= l && t.type === n))
                        return h;
                }
                if (s) {
                    const t = o[l];
                    if (t && Gt(t) && t.type === n) return l;
                }
                return null;
            }
            function Tn(t, e, n, r) {
                let s = t[n];
                const i = e.data;
                if (s instanceof sn) {
                    const o = s;
                    o.resolving &&
                        (function (t, e) {
                            throw new Jt(
                                "200",
                                `Circular dependency in DI detected for ${t}`
                            );
                        })($t(i[n]));
                    const a = fn(o.canSeeViewProviders);
                    o.resolving = !0;
                    const l = o.injectImpl ? gt(o.injectImpl) : null;
                    Le(t, r, pt.Default);
                    try {
                        (s = t[n] = o.factory(void 0, i, t, r)),
                            e.firstCreatePass &&
                                n >= r.directiveStart &&
                                (function (t, e, n) {
                                    const {
                                        ngOnChanges: r,
                                        ngOnInit: s,
                                        ngDoCheck: i,
                                    } = e.type.prototype;
                                    if (r) {
                                        const r = re(e);
                                        (
                                            n.preOrderHooks ||
                                            (n.preOrderHooks = [])
                                        ).push(t, r),
                                            (
                                                n.preOrderCheckHooks ||
                                                (n.preOrderCheckHooks = [])
                                            ).push(t, r);
                                    }
                                    s &&
                                        (
                                            n.preOrderHooks ||
                                            (n.preOrderHooks = [])
                                        ).push(0 - t, s),
                                        i &&
                                            ((
                                                n.preOrderHooks ||
                                                (n.preOrderHooks = [])
                                            ).push(t, i),
                                            (
                                                n.preOrderCheckHooks ||
                                                (n.preOrderCheckHooks = [])
                                            ).push(t, i));
                                })(n, i[n], e);
                    } finally {
                        null !== l && gt(l), fn(a), (o.resolving = !1), Ze();
                    }
                }
                return s;
            }
            function Sn(t, e, n) {
                return !!(n[e + (t >> 5)] & (1 << t));
            }
            function On(t, e) {
                return !(t & pt.Self || (t & pt.Host && e));
            }
            class Mn {
                constructor(t, e) {
                    (this._tNode = t), (this._lView = e);
                }
                get(t, e) {
                    return _n(this._tNode, this._lView, t, void 0, e);
                }
            }
            const Pn = "__parameters__";
            function Rn(t, e, n) {
                return yt(() => {
                    const r = (function (t) {
                        return function (...e) {
                            if (t) {
                                const n = t(...e);
                                for (const t in n) this[t] = n[t];
                            }
                        };
                    })(e);
                    function s(...t) {
                        if (this instanceof s) return r.apply(this, t), this;
                        const e = new s(...t);
                        return (n.annotation = e), n;
                        function n(t, n, r) {
                            const s = t.hasOwnProperty(Pn)
                                ? t[Pn]
                                : Object.defineProperty(t, Pn, { value: [] })[
                                      Pn
                                  ];
                            for (; s.length <= r; ) s.push(null);
                            return (s[r] = s[r] || []).push(e), t;
                        }
                    }
                    return (
                        n && (s.prototype = Object.create(n.prototype)),
                        (s.prototype.ngMetadataName = t),
                        (s.annotationCls = s),
                        s
                    );
                });
            }
            class Nn {
                constructor(t, e) {
                    (this._desc = t),
                        (this.ngMetadataName = "InjectionToken"),
                        (this.ɵprov = void 0),
                        "number" == typeof e
                            ? (this.__NG_ELEMENT_ID__ = e)
                            : void 0 !== e &&
                              (this.ɵprov = st({
                                  token: this,
                                  providedIn: e.providedIn || "root",
                                  factory: e.factory,
                              }));
                }
                toString() {
                    return `InjectionToken ${this._desc}`;
                }
            }
            const Dn = Function;
            function Vn(t) {
                return "function" == typeof t;
            }
            function Fn(t, e) {
                void 0 === e && (e = t);
                for (let n = 0; n < t.length; n++) {
                    let r = t[n];
                    Array.isArray(r)
                        ? (e === t && (e = t.slice(0, n)), Fn(r, e))
                        : e !== t && e.push(r);
                }
                return e;
            }
            function jn(t, e) {
                t.forEach((t) => (Array.isArray(t) ? jn(t, e) : e(t)));
            }
            function zn(t, e, n) {
                e >= t.length ? t.push(n) : t.splice(e, 0, n);
            }
            function Bn(t, e) {
                return e >= t.length - 1 ? t.pop() : t.splice(e, 1)[0];
            }
            function Hn(t, e) {
                const n = [];
                for (let r = 0; r < t; r++) n.push(e);
                return n;
            }
            function Ln(t, e, n) {
                let r = Kn(t, e);
                return (
                    r >= 0
                        ? (t[1 | r] = n)
                        : ((r = ~r),
                          (function (t, e, n, r) {
                              let s = t.length;
                              if (s == e) t.push(n, r);
                              else if (1 === s) t.push(r, t[0]), (t[0] = n);
                              else {
                                  for (s--, t.push(t[s - 1], t[s]); s > e; )
                                      (t[s] = t[s - 2]), s--;
                                  (t[e] = n), (t[e + 1] = r);
                              }
                          })(t, r, e, n)),
                    r
                );
            }
            function qn(t, e) {
                const n = Kn(t, e);
                if (n >= 0) return t[1 | n];
            }
            function Kn(t, e) {
                return (function (t, e, n) {
                    let r = 0,
                        s = t.length >> 1;
                    for (; s !== r; ) {
                        const n = r + ((s - r) >> 1),
                            i = t[n << 1];
                        if (e === i) return n << 1;
                        i > e ? (s = n) : (r = n + 1);
                    }
                    return ~(s << 1);
                })(t, e);
            }
            const Wn =
                    /^function\s+\S+\(\)\s*{[\s\S]+\.apply\(this,\s*(arguments|[^()]+\(arguments\))\)/,
                Un = /^class\s+[A-Za-z\d$_]*\s*extends\s+[^{]+{/,
                Zn =
                    /^class\s+[A-Za-z\d$_]*\s*extends\s+[^{]+{[\s\S]*constructor\s*\(/,
                Yn =
                    /^class\s+[A-Za-z\d$_]*\s*extends\s+[^{]+{[\s\S]*constructor\s*\(\)\s*{\s*super\(\.\.\.arguments\)/;
            class Gn {
                constructor(t) {
                    this._reflect = t || kt.Reflect;
                }
                isReflectionEnabled() {
                    return !0;
                }
                factory(t) {
                    return (...e) => new t(...e);
                }
                _zipTypesAndAnnotations(t, e) {
                    let n;
                    n = Hn(void 0 === t ? e.length : t.length);
                    for (let r = 0; r < n.length; r++)
                        (n[r] =
                            void 0 === t
                                ? []
                                : t[r] && t[r] != Object
                                ? [t[r]]
                                : []),
                            e && null != e[r] && (n[r] = n[r].concat(e[r]));
                    return n;
                }
                _ownParameters(t, e) {
                    if (
                        ((n = t.toString()),
                        Wn.test(n) || Yn.test(n) || (Un.test(n) && !Zn.test(n)))
                    )
                        return null;
                    var n;
                    if (t.parameters && t.parameters !== e.parameters)
                        return t.parameters;
                    const r = t.ctorParameters;
                    if (r && r !== e.ctorParameters) {
                        const t = "function" == typeof r ? r() : r,
                            e = t.map((t) => t && t.type),
                            n = t.map((t) => t && Xn(t.decorators));
                        return this._zipTypesAndAnnotations(e, n);
                    }
                    const s = t.hasOwnProperty(Pn) && t[Pn],
                        i =
                            this._reflect &&
                            this._reflect.getOwnMetadata &&
                            this._reflect.getOwnMetadata(
                                "design:paramtypes",
                                t
                            );
                    return i || s
                        ? this._zipTypesAndAnnotations(i, s)
                        : Hn(t.length);
                }
                parameters(t) {
                    if (!Vn(t)) return [];
                    const e = Jn(t);
                    let n = this._ownParameters(t, e);
                    return (
                        n || e === Object || (n = this.parameters(e)), n || []
                    );
                }
                _ownAnnotations(t, e) {
                    if (t.annotations && t.annotations !== e.annotations) {
                        let e = t.annotations;
                        return (
                            "function" == typeof e &&
                                e.annotations &&
                                (e = e.annotations),
                            e
                        );
                    }
                    return t.decorators && t.decorators !== e.decorators
                        ? Xn(t.decorators)
                        : t.hasOwnProperty("__annotations__")
                        ? t.__annotations__
                        : null;
                }
                annotations(t) {
                    if (!Vn(t)) return [];
                    const e = Jn(t),
                        n = this._ownAnnotations(t, e) || [];
                    return (e !== Object ? this.annotations(e) : []).concat(n);
                }
                _ownPropMetadata(t, e) {
                    if (t.propMetadata && t.propMetadata !== e.propMetadata) {
                        let e = t.propMetadata;
                        return (
                            "function" == typeof e &&
                                e.propMetadata &&
                                (e = e.propMetadata),
                            e
                        );
                    }
                    if (
                        t.propDecorators &&
                        t.propDecorators !== e.propDecorators
                    ) {
                        const e = t.propDecorators,
                            n = {};
                        return (
                            Object.keys(e).forEach((t) => {
                                n[t] = Xn(e[t]);
                            }),
                            n
                        );
                    }
                    return t.hasOwnProperty("__prop__metadata__")
                        ? t.__prop__metadata__
                        : null;
                }
                propMetadata(t) {
                    if (!Vn(t)) return {};
                    const e = Jn(t),
                        n = {};
                    if (e !== Object) {
                        const t = this.propMetadata(e);
                        Object.keys(t).forEach((e) => {
                            n[e] = t[e];
                        });
                    }
                    const r = this._ownPropMetadata(t, e);
                    return (
                        r &&
                            Object.keys(r).forEach((t) => {
                                const e = [];
                                n.hasOwnProperty(t) && e.push(...n[t]),
                                    e.push(...r[t]),
                                    (n[t] = e);
                            }),
                        n
                    );
                }
                ownPropMetadata(t) {
                    return (Vn(t) && this._ownPropMetadata(t, Jn(t))) || {};
                }
                hasLifecycleHook(t, e) {
                    return t instanceof Dn && e in t.prototype;
                }
                guards(t) {
                    return {};
                }
                getter(t) {
                    return new Function("o", "return o." + t + ";");
                }
                setter(t) {
                    return new Function("o", "v", "return o." + t + " = v;");
                }
                method(t) {
                    return new Function(
                        "o",
                        "args",
                        `if (!o.${t}) throw new Error('"${t}" is undefined');\n        return o.${t}.apply(o, args);`
                    );
                }
                importUri(t) {
                    return "object" == typeof t && t.filePath
                        ? t.filePath
                        : `./${$(t)}`;
                }
                resourceUri(t) {
                    return `./${$(t)}`;
                }
                resolveIdentifier(t, e, n, r) {
                    return r;
                }
                resolveEnum(t, e) {
                    return t[e];
                }
            }
            function Xn(t) {
                return t
                    ? t.map(
                          (t) =>
                              new (0, t.type.annotationCls)(
                                  ...(t.args ? t.args : [])
                              )
                      )
                    : [];
            }
            function Jn(t) {
                const e = t.prototype
                    ? Object.getPrototypeOf(t.prototype)
                    : null;
                return (e ? e.constructor : null) || Object;
            }
            const Qn = {},
                $n = /\n/gm,
                tr = Q({ provide: String, useValue: Q });
            let er;
            function nr(t) {
                const e = er;
                return (er = t), e;
            }
            function rr(t, e = pt.Default) {
                if (void 0 === er)
                    throw new Error(
                        "inject() must be called from an injection context"
                    );
                return null === er
                    ? mt(t, void 0, e)
                    : er.get(t, e & pt.Optional ? null : void 0, e);
            }
            function sr(t, e = pt.Default) {
                return (ft || rr)(rt(t), e);
            }
            function ir(t) {
                const e = [];
                for (let n = 0; n < t.length; n++) {
                    const r = rt(t[n]);
                    if (Array.isArray(r)) {
                        if (0 === r.length)
                            throw new Error(
                                "Arguments array must have arguments."
                            );
                        let t,
                            n = pt.Default;
                        for (let e = 0; e < r.length; e++) {
                            const s = r[e],
                                i = s.__NG_DI_FLAG__;
                            "number" == typeof i
                                ? -1 === i
                                    ? (t = s.token)
                                    : (n |= i)
                                : (t = s);
                        }
                        e.push(sr(t, n));
                    } else e.push(sr(r));
                }
                return e;
            }
            function or(t, e) {
                return (
                    (t.__NG_DI_FLAG__ = e), (t.prototype.__NG_DI_FLAG__ = e), t
                );
            }
            const ar = or(
                    Rn("Inject", (t) => ({ token: t })),
                    -1
                ),
                lr = or(Rn("Optional"), 8),
                cr = or(Rn("Self"), 2),
                ur = or(Rn("SkipSelf"), 4);
            let hr, dr;
            function pr(t) {
                var e;
                return (
                    (null ===
                        (e = (function () {
                            if (void 0 === hr && ((hr = null), kt.trustedTypes))
                                try {
                                    hr = kt.trustedTypes.createPolicy(
                                        "angular",
                                        {
                                            createHTML: (t) => t,
                                            createScript: (t) => t,
                                            createScriptURL: (t) => t,
                                        }
                                    );
                                } catch (e) {}
                            return hr;
                        })()) || void 0 === e
                        ? void 0
                        : e.createHTML(t)) || t
                );
            }
            function fr(t) {
                var e;
                return (
                    (null ===
                        (e = (function () {
                            if (void 0 === dr && ((dr = null), kt.trustedTypes))
                                try {
                                    dr = kt.trustedTypes.createPolicy(
                                        "angular#unsafe-bypass",
                                        {
                                            createHTML: (t) => t,
                                            createScript: (t) => t,
                                            createScriptURL: (t) => t,
                                        }
                                    );
                                } catch (e) {}
                            return dr;
                        })()) || void 0 === e
                        ? void 0
                        : e.createHTML(t)) || t
                );
            }
            class gr {
                constructor(t) {
                    this.changingThisBreaksApplicationSecurity = t;
                }
                toString() {
                    return `SafeValue must use [property]=binding: ${this.changingThisBreaksApplicationSecurity} (see https://g.co/ng/security#xss)`;
                }
            }
            class mr extends gr {
                getTypeName() {
                    return "HTML";
                }
            }
            class yr extends gr {
                getTypeName() {
                    return "Style";
                }
            }
            class vr extends gr {
                getTypeName() {
                    return "Script";
                }
            }
            class br extends gr {
                getTypeName() {
                    return "URL";
                }
            }
            class wr extends gr {
                getTypeName() {
                    return "ResourceURL";
                }
            }
            function Cr(t) {
                return t instanceof gr
                    ? t.changingThisBreaksApplicationSecurity
                    : t;
            }
            function xr(t, e) {
                const n = _r(t);
                if (null != n && n !== e) {
                    if ("ResourceURL" === n && "URL" === e) return !0;
                    throw new Error(
                        `Required a safe ${e}, got a ${n} (see https://g.co/ng/security#xss)`
                    );
                }
                return n === e;
            }
            function _r(t) {
                return (t instanceof gr && t.getTypeName()) || null;
            }
            class kr {
                constructor(t) {
                    this.inertDocumentHelper = t;
                }
                getInertBodyElement(t) {
                    t = "<body><remove></remove>" + t;
                    try {
                        const e = new window.DOMParser().parseFromString(
                            pr(t),
                            "text/html"
                        ).body;
                        return null === e
                            ? this.inertDocumentHelper.getInertBodyElement(t)
                            : (e.removeChild(e.firstChild), e);
                    } catch (e) {
                        return null;
                    }
                }
            }
            class Ar {
                constructor(t) {
                    if (
                        ((this.defaultDoc = t),
                        (this.inertDocument =
                            this.defaultDoc.implementation.createHTMLDocument(
                                "sanitization-inert"
                            )),
                        null == this.inertDocument.body)
                    ) {
                        const t = this.inertDocument.createElement("html");
                        this.inertDocument.appendChild(t);
                        const e = this.inertDocument.createElement("body");
                        t.appendChild(e);
                    }
                }
                getInertBodyElement(t) {
                    const e = this.inertDocument.createElement("template");
                    if ("content" in e) return (e.innerHTML = pr(t)), e;
                    const n = this.inertDocument.createElement("body");
                    return (
                        (n.innerHTML = pr(t)),
                        this.defaultDoc.documentMode &&
                            this.stripCustomNsAttrs(n),
                        n
                    );
                }
                stripCustomNsAttrs(t) {
                    const e = t.attributes;
                    for (let r = e.length - 1; 0 < r; r--) {
                        const n = e.item(r).name;
                        ("xmlns:ns1" !== n && 0 !== n.indexOf("ns1:")) ||
                            t.removeAttribute(n);
                    }
                    let n = t.firstChild;
                    for (; n; )
                        n.nodeType === Node.ELEMENT_NODE &&
                            this.stripCustomNsAttrs(n),
                            (n = n.nextSibling);
                }
            }
            const Er =
                    /^(?:(?:https?|mailto|ftp|tel|file|sms):|[^&:/?#]*(?:[/?#]|$))/gi,
                Ir =
                    /^data:(?:image\/(?:bmp|gif|jpeg|jpg|png|tiff|webp)|video\/(?:mpeg|mp4|ogg|webm)|audio\/(?:mp3|oga|ogg|opus));base64,[a-z0-9+\/]+=*$/i;
            function Tr(t) {
                return (t = String(t)).match(Er) || t.match(Ir)
                    ? t
                    : "unsafe:" + t;
            }
            function Sr(t) {
                const e = {};
                for (const n of t.split(",")) e[n] = !0;
                return e;
            }
            function Or(...t) {
                const e = {};
                for (const n of t)
                    for (const t in n) n.hasOwnProperty(t) && (e[t] = !0);
                return e;
            }
            const Mr = Sr("area,br,col,hr,img,wbr"),
                Pr = Sr("colgroup,dd,dt,li,p,tbody,td,tfoot,th,thead,tr"),
                Rr = Sr("rp,rt"),
                Nr = Or(Rr, Pr),
                Dr = Or(
                    Mr,
                    Or(
                        Pr,
                        Sr(
                            "address,article,aside,blockquote,caption,center,del,details,dialog,dir,div,dl,figure,figcaption,footer,h1,h2,h3,h4,h5,h6,header,hgroup,hr,ins,main,map,menu,nav,ol,pre,section,summary,table,ul"
                        )
                    ),
                    Or(
                        Rr,
                        Sr(
                            "a,abbr,acronym,audio,b,bdi,bdo,big,br,cite,code,del,dfn,em,font,i,img,ins,kbd,label,map,mark,picture,q,ruby,rp,rt,s,samp,small,source,span,strike,strong,sub,sup,time,track,tt,u,var,video"
                        )
                    ),
                    Nr
                ),
                Vr = Sr(
                    "background,cite,href,itemtype,longdesc,poster,src,xlink:href"
                ),
                Fr = Sr("srcset"),
                jr = Or(
                    Vr,
                    Fr,
                    Sr(
                        "abbr,accesskey,align,alt,autoplay,axis,bgcolor,border,cellpadding,cellspacing,class,clear,color,cols,colspan,compact,controls,coords,datetime,default,dir,download,face,headers,height,hidden,hreflang,hspace,ismap,itemscope,itemprop,kind,label,lang,language,loop,media,muted,nohref,nowrap,open,preload,rel,rev,role,rows,rowspan,rules,scope,scrolling,shape,size,sizes,span,srclang,start,summary,tabindex,target,title,translate,type,usemap,valign,value,vspace,width"
                    ),
                    Sr(
                        "aria-activedescendant,aria-atomic,aria-autocomplete,aria-busy,aria-checked,aria-colcount,aria-colindex,aria-colspan,aria-controls,aria-current,aria-describedby,aria-details,aria-disabled,aria-dropeffect,aria-errormessage,aria-expanded,aria-flowto,aria-grabbed,aria-haspopup,aria-hidden,aria-invalid,aria-keyshortcuts,aria-label,aria-labelledby,aria-level,aria-live,aria-modal,aria-multiline,aria-multiselectable,aria-orientation,aria-owns,aria-placeholder,aria-posinset,aria-pressed,aria-readonly,aria-relevant,aria-required,aria-roledescription,aria-rowcount,aria-rowindex,aria-rowspan,aria-selected,aria-setsize,aria-sort,aria-valuemax,aria-valuemin,aria-valuenow,aria-valuetext"
                    )
                ),
                zr = Sr("script,style,template");
            class Br {
                constructor() {
                    (this.sanitizedSomething = !1), (this.buf = []);
                }
                sanitizeChildren(t) {
                    let e = t.firstChild,
                        n = !0;
                    for (; e; )
                        if (
                            (e.nodeType === Node.ELEMENT_NODE
                                ? (n = this.startElement(e))
                                : e.nodeType === Node.TEXT_NODE
                                ? this.chars(e.nodeValue)
                                : (this.sanitizedSomething = !0),
                            n && e.firstChild)
                        )
                            e = e.firstChild;
                        else
                            for (; e; ) {
                                e.nodeType === Node.ELEMENT_NODE &&
                                    this.endElement(e);
                                let t = this.checkClobberedElement(
                                    e,
                                    e.nextSibling
                                );
                                if (t) {
                                    e = t;
                                    break;
                                }
                                e = this.checkClobberedElement(e, e.parentNode);
                            }
                    return this.buf.join("");
                }
                startElement(t) {
                    const e = t.nodeName.toLowerCase();
                    if (!Dr.hasOwnProperty(e))
                        return (
                            (this.sanitizedSomething = !0),
                            !zr.hasOwnProperty(e)
                        );
                    this.buf.push("<"), this.buf.push(e);
                    const n = t.attributes;
                    for (let s = 0; s < n.length; s++) {
                        const t = n.item(s),
                            e = t.name,
                            i = e.toLowerCase();
                        if (!jr.hasOwnProperty(i)) {
                            this.sanitizedSomething = !0;
                            continue;
                        }
                        let o = t.value;
                        Vr[i] && (o = Tr(o)),
                            Fr[i] &&
                                ((r = o),
                                (o = (r = String(r))
                                    .split(",")
                                    .map((t) => Tr(t.trim()))
                                    .join(", "))),
                            this.buf.push(" ", e, '="', qr(o), '"');
                    }
                    var r;
                    return this.buf.push(">"), !0;
                }
                endElement(t) {
                    const e = t.nodeName.toLowerCase();
                    Dr.hasOwnProperty(e) &&
                        !Mr.hasOwnProperty(e) &&
                        (this.buf.push("</"),
                        this.buf.push(e),
                        this.buf.push(">"));
                }
                chars(t) {
                    this.buf.push(qr(t));
                }
                checkClobberedElement(t, e) {
                    if (
                        e &&
                        (t.compareDocumentPosition(e) &
                            Node.DOCUMENT_POSITION_CONTAINED_BY) ===
                            Node.DOCUMENT_POSITION_CONTAINED_BY
                    )
                        throw new Error(
                            `Failed to sanitize html because the element is clobbered: ${t.outerHTML}`
                        );
                    return e;
                }
            }
            const Hr = /[\uD800-\uDBFF][\uDC00-\uDFFF]/g,
                Lr = /([^\#-~ |!])/g;
            function qr(t) {
                return t
                    .replace(/&/g, "&amp;")
                    .replace(Hr, function (t) {
                        return (
                            "&#" +
                            (1024 * (t.charCodeAt(0) - 55296) +
                                (t.charCodeAt(1) - 56320) +
                                65536) +
                            ";"
                        );
                    })
                    .replace(Lr, function (t) {
                        return "&#" + t.charCodeAt(0) + ";";
                    })
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;");
            }
            let Kr;
            function Wr(t, e) {
                let n = null;
                try {
                    Kr =
                        Kr ||
                        (function (t) {
                            const e = new Ar(t);
                            return (function () {
                                try {
                                    return !!new window.DOMParser().parseFromString(
                                        pr(""),
                                        "text/html"
                                    );
                                } catch (t) {
                                    return !1;
                                }
                            })()
                                ? new kr(e)
                                : e;
                        })(t);
                    let r = e ? String(e) : "";
                    n = Kr.getInertBodyElement(r);
                    let s = 5,
                        i = r;
                    do {
                        if (0 === s)
                            throw new Error(
                                "Failed to sanitize html because the input is unstable"
                            );
                        s--,
                            (r = i),
                            (i = n.innerHTML),
                            (n = Kr.getInertBodyElement(r));
                    } while (r !== i);
                    return pr(new Br().sanitizeChildren(Ur(n) || n));
                } finally {
                    if (n) {
                        const t = Ur(n) || n;
                        for (; t.firstChild; ) t.removeChild(t.firstChild);
                    }
                }
            }
            function Ur(t) {
                return "content" in t &&
                    (function (t) {
                        return (
                            t.nodeType === Node.ELEMENT_NODE &&
                            "TEMPLATE" === t.nodeName
                        );
                    })(t)
                    ? t.content
                    : null;
            }
            var Zr = (function (t) {
                return (
                    (t[(t.NONE = 0)] = "NONE"),
                    (t[(t.HTML = 1)] = "HTML"),
                    (t[(t.STYLE = 2)] = "STYLE"),
                    (t[(t.SCRIPT = 3)] = "SCRIPT"),
                    (t[(t.URL = 4)] = "URL"),
                    (t[(t.RESOURCE_URL = 5)] = "RESOURCE_URL"),
                    t
                );
            })({});
            function Yr(t) {
                const e = (function () {
                    const t = ke();
                    return t && t[12];
                })();
                return e
                    ? fr(e.sanitize(Zr.HTML, t) || "")
                    : xr(t, "HTML")
                    ? fr(Cr(t))
                    : Wr(le(), Qt(t));
            }
            function Gr(t) {
                return t.ngDebugContext;
            }
            function Xr(t) {
                return t.ngOriginalError;
            }
            function Jr(t, ...e) {
                t.error(...e);
            }
            class Qr {
                constructor() {
                    this._console = console;
                }
                handleError(t) {
                    const e = this._findOriginalError(t),
                        n = this._findContext(t),
                        r = (function (t) {
                            return t.ngErrorLogger || Jr;
                        })(t);
                    r(this._console, "ERROR", t),
                        e && r(this._console, "ORIGINAL ERROR", e),
                        n && r(this._console, "ERROR CONTEXT", n);
                }
                _findContext(t) {
                    return t
                        ? Gr(t)
                            ? Gr(t)
                            : this._findContext(Xr(t))
                        : null;
                }
                _findOriginalError(t) {
                    let e = Xr(t);
                    for (; e && Xr(e); ) e = Xr(e);
                    return e;
                }
            }
            function $r(t, e) {
                t.__ngContext__ = e;
            }
            const ts = (() =>
                (
                    ("undefined" != typeof requestAnimationFrame &&
                        requestAnimationFrame) ||
                    setTimeout
                ).bind(kt))();
            function es(t) {
                return { name: "document", target: t.ownerDocument };
            }
            function ns(t) {
                return t instanceof Function ? t() : t;
            }
            var rs = (function (t) {
                return (
                    (t[(t.Important = 1)] = "Important"),
                    (t[(t.DashCase = 2)] = "DashCase"),
                    t
                );
            })({});
            function ss(t, e) {
                return (void 0)(t, e);
            }
            function is(t) {
                const e = t[3];
                return Wt(e) ? e[3] : e;
            }
            function os(t) {
                return ls(t[13]);
            }
            function as(t) {
                return ls(t[4]);
            }
            function ls(t) {
                for (; null !== t && !Wt(t); ) t = t[4];
                return t;
            }
            function cs(t, e, n, r, s) {
                if (null != r) {
                    let i,
                        o = !1;
                    Wt(r) ? (i = r) : Kt(r) && ((o = !0), (r = r[0]));
                    const a = he(r);
                    0 === t && null !== n
                        ? null == s
                            ? ys(e, n, a)
                            : ms(e, n, a, s || null, !0)
                        : 1 === t && null !== n
                        ? ms(e, n, a, s || null, !0)
                        : 2 === t
                        ? (function (t, e, n) {
                              const r = bs(t, e);
                              r &&
                                  (function (t, e, n, r) {
                                      ce(t)
                                          ? t.removeChild(e, n, r)
                                          : e.removeChild(n);
                                  })(t, r, e, n);
                          })(e, a, o)
                        : 3 === t && e.destroyNode(a),
                        null != i &&
                            (function (t, e, n, r, s) {
                                const i = n[7];
                                i !== he(n) && cs(e, t, r, i, s);
                                for (let o = 10; o < n.length; o++) {
                                    const s = n[o];
                                    Es(s[1], s, t, e, r, i);
                                }
                            })(e, t, i, n, s);
                }
            }
            function us(t, e, n) {
                return ce(t)
                    ? t.createElement(e, n)
                    : null === n
                    ? t.createElement(e)
                    : t.createElementNS(n, e);
            }
            function hs(t, e) {
                const n = t[9],
                    r = n.indexOf(e),
                    s = e[3];
                1024 & e[2] && ((e[2] &= -1025), Ce(s, -1)), n.splice(r, 1);
            }
            function ds(t, e) {
                if (t.length <= 10) return;
                const n = 10 + e,
                    r = t[n];
                if (r) {
                    const i = r[17];
                    null !== i && i !== t && hs(i, r),
                        e > 0 && (t[n - 1][4] = r[4]);
                    const o = Bn(t, 10 + e);
                    Es(r[1], (s = r), s[11], 2, null, null),
                        (s[0] = null),
                        (s[6] = null);
                    const a = o[19];
                    null !== a && a.detachView(o[1]),
                        (r[3] = null),
                        (r[4] = null),
                        (r[2] &= -129);
                }
                var s;
                return r;
            }
            function ps(t, e) {
                if (!(256 & e[2])) {
                    const n = e[11];
                    ce(n) && n.destroyNode && Es(t, e, n, 3, null, null),
                        (function (t) {
                            let e = t[13];
                            if (!e) return fs(t[1], t);
                            for (; e; ) {
                                let n = null;
                                if (Kt(e)) n = e[13];
                                else {
                                    const t = e[10];
                                    t && (n = t);
                                }
                                if (!n) {
                                    for (; e && !e[4] && e !== t; )
                                        Kt(e) && fs(e[1], e), (e = e[3]);
                                    null === e && (e = t),
                                        Kt(e) && fs(e[1], e),
                                        (n = e && e[4]);
                                }
                                e = n;
                            }
                        })(e);
                }
            }
            function fs(t, e) {
                if (!(256 & e[2])) {
                    (e[2] &= -129),
                        (e[2] |= 256),
                        (function (t, e) {
                            let n;
                            if (null != t && null != (n = t.destroyHooks))
                                for (let r = 0; r < n.length; r += 2) {
                                    const t = e[n[r]];
                                    if (!(t instanceof sn)) {
                                        const e = n[r + 1];
                                        if (Array.isArray(e))
                                            for (
                                                let n = 0;
                                                n < e.length;
                                                n += 2
                                            )
                                                e[n + 1].call(t[e[n]]);
                                        else e.call(t);
                                    }
                                }
                        })(t, e),
                        (function (t, e) {
                            const n = t.cleanup,
                                r = e[7];
                            let s = -1;
                            if (null !== n)
                                for (let i = 0; i < n.length - 1; i += 2)
                                    if ("string" == typeof n[i]) {
                                        const t = n[i + 1],
                                            o =
                                                "function" == typeof t
                                                    ? t(e)
                                                    : he(e[t]),
                                            a = r[(s = n[i + 2])],
                                            l = n[i + 3];
                                        "boolean" == typeof l
                                            ? o.removeEventListener(n[i], a, l)
                                            : l >= 0
                                            ? r[(s = l)]()
                                            : r[(s = -l)].unsubscribe(),
                                            (i += 2);
                                    } else {
                                        const t = r[(s = n[i + 1])];
                                        n[i].call(t);
                                    }
                            if (null !== r) {
                                for (let t = s + 1; t < r.length; t++)
                                    (0, r[t])();
                                e[7] = null;
                            }
                        })(t, e),
                        1 === e[1].type && ce(e[11]) && e[11].destroy();
                    const n = e[17];
                    if (null !== n && Wt(e[3])) {
                        n !== e[3] && hs(n, e);
                        const r = e[19];
                        null !== r && r.detachView(t);
                    }
                }
            }
            function gs(t, e, n) {
                return (function (t, e, n) {
                    let r = e;
                    for (; null !== r && 40 & r.type; ) r = (e = r).parent;
                    if (null === r) return n[0];
                    if (2 & r.flags) {
                        const e = t.data[r.directiveStart].encapsulation;
                        if (e === bt.None || e === bt.Emulated) return null;
                    }
                    return pe(r, n);
                })(t, e.parent, n);
            }
            function ms(t, e, n, r, s) {
                ce(t) ? t.insertBefore(e, n, r, s) : e.insertBefore(n, r, s);
            }
            function ys(t, e, n) {
                ce(t) ? t.appendChild(e, n) : e.appendChild(n);
            }
            function vs(t, e, n, r, s) {
                null !== r ? ms(t, e, n, r, s) : ys(t, e, n);
            }
            function bs(t, e) {
                return ce(t) ? t.parentNode(e) : e.parentNode;
            }
            function ws(t, e, n) {
                return Cs(t, e, n);
            }
            let Cs = function (t, e, n) {
                return 40 & t.type ? pe(t, n) : null;
            };
            function xs(t, e, n, r) {
                const s = gs(t, r, e),
                    i = e[11],
                    o = ws(r.parent || e[6], r, e);
                if (null != s)
                    if (Array.isArray(n))
                        for (let a = 0; a < n.length; a++)
                            vs(i, s, n[a], o, !1);
                    else vs(i, s, n, o, !1);
            }
            function _s(t, e) {
                if (null !== e) {
                    const n = e.type;
                    if (3 & n) return pe(e, t);
                    if (4 & n) return ks(-1, t[e.index]);
                    if (8 & n) {
                        const n = e.child;
                        if (null !== n) return _s(t, n);
                        {
                            const n = t[e.index];
                            return Wt(n) ? ks(-1, n) : he(n);
                        }
                    }
                    if (32 & n) return ss(e, t)() || he(t[e.index]);
                    {
                        const n = t[16],
                            r = n[6],
                            s = is(n),
                            i = r.projection[e.projection];
                        return null != i ? _s(s, i) : _s(t, e.next);
                    }
                }
                return null;
            }
            function ks(t, e) {
                const n = 10 + t + 1;
                if (n < e.length) {
                    const t = e[n],
                        r = t[1].firstChild;
                    if (null !== r) return _s(t, r);
                }
                return e[7];
            }
            function As(t, e, n, r, s, i, o) {
                for (; null != n; ) {
                    const a = r[n.index],
                        l = n.type;
                    if (
                        (o && 0 === e && (a && $r(he(a), r), (n.flags |= 4)),
                        64 != (64 & n.flags))
                    )
                        if (8 & l)
                            As(t, e, n.child, r, s, i, !1), cs(e, t, s, a, i);
                        else if (32 & l) {
                            const o = ss(n, r);
                            let l;
                            for (; (l = o()); ) cs(e, t, s, l, i);
                            cs(e, t, s, a, i);
                        } else
                            16 & l ? Is(t, e, r, n, s, i) : cs(e, t, s, a, i);
                    n = o ? n.projectionNext : n.next;
                }
            }
            function Es(t, e, n, r, s, i) {
                As(n, r, t.firstChild, e, s, i, !1);
            }
            function Is(t, e, n, r, s, i) {
                const o = n[16],
                    a = o[6].projection[r.projection];
                if (Array.isArray(a))
                    for (let l = 0; l < a.length; l++) cs(e, t, s, a[l], i);
                else As(t, e, a, o[3], s, i, !0);
            }
            function Ts(t, e, n) {
                ce(t) ? t.setAttribute(e, "style", n) : (e.style.cssText = n);
            }
            function Ss(t, e, n) {
                ce(t)
                    ? "" === n
                        ? t.removeAttribute(e, "class")
                        : t.setAttribute(e, "class", n)
                    : (e.className = n);
            }
            function Os(t, e, n) {
                let r = t.length;
                for (;;) {
                    const s = t.indexOf(e, n);
                    if (-1 === s) return s;
                    if (0 === s || t.charCodeAt(s - 1) <= 32) {
                        const n = e.length;
                        if (s + n === r || t.charCodeAt(s + n) <= 32) return s;
                    }
                    n = s + 1;
                }
            }
            function Ms(t, e, n) {
                let r = 0;
                for (; r < t.length; ) {
                    let s = t[r++];
                    if (n && "class" === s) {
                        if (((s = t[r]), -1 !== Os(s.toLowerCase(), e, 0)))
                            return !0;
                    } else if (1 === s) {
                        for (
                            ;
                            r < t.length && "string" == typeof (s = t[r++]);

                        )
                            if (s.toLowerCase() === e) return !0;
                        return !1;
                    }
                }
                return !1;
            }
            function Ps(t) {
                return 4 === t.type && "ng-template" !== t.value;
            }
            function Rs(t, e, n) {
                return e === (4 !== t.type || n ? t.value : "ng-template");
            }
            function Ns(t, e, n) {
                let r = 4;
                const s = t.attrs || [],
                    i = (function (t) {
                        for (let n = 0; n < t.length; n++)
                            if (3 === (e = t[n]) || 4 === e || 6 === e)
                                return n;
                        var e;
                        return t.length;
                    })(s);
                let o = !1;
                for (let a = 0; a < e.length; a++) {
                    const l = e[a];
                    if ("number" != typeof l) {
                        if (!o)
                            if (4 & r) {
                                if (
                                    ((r = 2 | (1 & r)),
                                    ("" !== l && !Rs(t, l, n)) ||
                                        ("" === l && 1 === e.length))
                                ) {
                                    if (Ds(r)) return !1;
                                    o = !0;
                                }
                            } else {
                                const c = 8 & r ? l : e[++a];
                                if (8 & r && null !== t.attrs) {
                                    if (!Ms(t.attrs, c, n)) {
                                        if (Ds(r)) return !1;
                                        o = !0;
                                    }
                                    continue;
                                }
                                const u = Vs(8 & r ? "class" : l, s, Ps(t), n);
                                if (-1 === u) {
                                    if (Ds(r)) return !1;
                                    o = !0;
                                    continue;
                                }
                                if ("" !== c) {
                                    let t;
                                    t = u > i ? "" : s[u + 1].toLowerCase();
                                    const e = 8 & r ? t : null;
                                    if (
                                        (e && -1 !== Os(e, c, 0)) ||
                                        (2 & r && c !== t)
                                    ) {
                                        if (Ds(r)) return !1;
                                        o = !0;
                                    }
                                }
                            }
                    } else {
                        if (!o && !Ds(r) && !Ds(l)) return !1;
                        if (o && Ds(l)) continue;
                        (o = !1), (r = l | (1 & r));
                    }
                }
                return Ds(r) || o;
            }
            function Ds(t) {
                return 0 == (1 & t);
            }
            function Vs(t, e, n, r) {
                if (null === e) return -1;
                let s = 0;
                if (r || !n) {
                    let n = !1;
                    for (; s < e.length; ) {
                        const r = e[s];
                        if (r === t) return s;
                        if (3 === r || 6 === r) n = !0;
                        else {
                            if (1 === r || 2 === r) {
                                let t = e[++s];
                                for (; "string" == typeof t; ) t = e[++s];
                                continue;
                            }
                            if (4 === r) break;
                            if (0 === r) {
                                s += 4;
                                continue;
                            }
                        }
                        s += n ? 1 : 2;
                    }
                    return -1;
                }
                return (function (t, e) {
                    let n = t.indexOf(4);
                    if (n > -1)
                        for (n++; n < t.length; ) {
                            const r = t[n];
                            if ("number" == typeof r) return -1;
                            if (r === e) return n;
                            n++;
                        }
                    return -1;
                })(e, t);
            }
            function Fs(t, e, n = !1) {
                for (let r = 0; r < e.length; r++)
                    if (Ns(t, e[r], n)) return !0;
                return !1;
            }
            function js(t, e) {
                return t ? ":not(" + e.trim() + ")" : e;
            }
            function zs(t) {
                let e = t[0],
                    n = 1,
                    r = 2,
                    s = "",
                    i = !1;
                for (; n < t.length; ) {
                    let o = t[n];
                    if ("string" == typeof o)
                        if (2 & r) {
                            const e = t[++n];
                            s +=
                                "[" +
                                o +
                                (e.length > 0 ? '="' + e + '"' : "") +
                                "]";
                        } else 8 & r ? (s += "." + o) : 4 & r && (s += " " + o);
                    else
                        "" === s || Ds(o) || ((e += js(i, s)), (s = "")),
                            (r = o),
                            (i = i || !Ds(r));
                    n++;
                }
                return "" !== s && (e += js(i, s)), e;
            }
            const Bs = {};
            function Hs(t) {
                Ls(Ae(), ke(), Ge() + t, Pe());
            }
            function Ls(t, e, n, r) {
                if (!r)
                    if (3 == (3 & e[2])) {
                        const r = t.preOrderCheckHooks;
                        null !== r && $e(e, r, n);
                    } else {
                        const r = t.preOrderHooks;
                        null !== r && tn(e, r, 0, n);
                    }
                Xe(n);
            }
            function qs(t, e) {
                return (t << 17) | (e << 2);
            }
            function Ks(t) {
                return (t >> 17) & 32767;
            }
            function Ws(t) {
                return 2 | t;
            }
            function Us(t) {
                return (131068 & t) >> 2;
            }
            function Zs(t, e) {
                return (-131069 & t) | (e << 2);
            }
            function Ys(t) {
                return 1 | t;
            }
            function Gs(t, e) {
                const n = t.contentQueries;
                if (null !== n)
                    for (let r = 0; r < n.length; r += 2) {
                        const s = n[r],
                            i = n[r + 1];
                        if (-1 !== i) {
                            const n = t.data[i];
                            Be(s), n.contentQueries(2, e[i], i);
                        }
                    }
            }
            function Xs(t, e, n, r, s, i, o, a, l, c) {
                const u = e.blueprint.slice();
                return (
                    (u[0] = s),
                    (u[2] = 140 | r),
                    we(u),
                    (u[3] = u[15] = t),
                    (u[8] = n),
                    (u[10] = o || (t && t[10])),
                    (u[11] = a || (t && t[11])),
                    (u[12] = l || (t && t[12]) || null),
                    (u[9] = c || (t && t[9]) || null),
                    (u[6] = i),
                    (u[16] = 2 == e.type ? t[16] : u),
                    u
                );
            }
            function Js(t, e, n, r, s) {
                let i = t.data[e];
                if (null === i)
                    (i = (function (t, e, n, r, s) {
                        const i = Te(),
                            o = Oe(),
                            a = (t.data[e] = (function (t, e, n, r, s, i) {
                                return {
                                    type: n,
                                    index: r,
                                    insertBeforeIndex: null,
                                    injectorIndex: e ? e.injectorIndex : -1,
                                    directiveStart: -1,
                                    directiveEnd: -1,
                                    directiveStylingLast: -1,
                                    propertyBindings: null,
                                    flags: 0,
                                    providerIndexes: 0,
                                    value: s,
                                    attrs: i,
                                    mergedAttrs: null,
                                    localNames: null,
                                    initialInputs: void 0,
                                    inputs: null,
                                    outputs: null,
                                    tViews: null,
                                    next: null,
                                    projectionNext: null,
                                    child: null,
                                    parent: e,
                                    projection: null,
                                    styles: null,
                                    stylesWithoutHost: null,
                                    residualStyles: void 0,
                                    classes: null,
                                    classesWithoutHost: null,
                                    residualClasses: void 0,
                                    classBindings: 0,
                                    styleBindings: 0,
                                };
                            })(0, o ? i : i && i.parent, n, e, r, s));
                        return (
                            null === t.firstChild && (t.firstChild = a),
                            null !== i &&
                                (o
                                    ? null == i.child &&
                                      null !== a.parent &&
                                      (i.child = a)
                                    : null === i.next && (i.next = a)),
                            a
                        );
                    })(t, e, n, r, s)),
                        xe.lFrame.inI18n && (i.flags |= 64);
                else if (64 & i.type) {
                    (i.type = n), (i.value = r), (i.attrs = s);
                    const t = (function () {
                        const t = xe.lFrame,
                            e = t.currentTNode;
                        return t.isParent ? e : e.parent;
                    })();
                    i.injectorIndex = null === t ? -1 : t.injectorIndex;
                }
                return Se(i, !0), i;
            }
            function Qs(t, e, n, r) {
                if (0 === n) return -1;
                const s = e.length;
                for (let i = 0; i < n; i++)
                    e.push(r), t.blueprint.push(r), t.data.push(null);
                return s;
            }
            function $s(t, e, n) {
                qe(e);
                try {
                    const r = t.viewQuery;
                    null !== r && Si(1, r, n);
                    const s = t.template;
                    null !== s && ni(t, e, s, 1, n),
                        t.firstCreatePass && (t.firstCreatePass = !1),
                        t.staticContentQueries && Gs(t, e),
                        t.staticViewQueries && Si(2, t.viewQuery, n);
                    const i = t.components;
                    null !== i &&
                        (function (t, e) {
                            for (let n = 0; n < e.length; n++) ki(t, e[n]);
                        })(e, i);
                } catch (r) {
                    throw (
                        (t.firstCreatePass && (t.incompleteFirstPass = !0), r)
                    );
                } finally {
                    (e[2] &= -5), Ye();
                }
            }
            function ti(t, e, n, r) {
                const s = e[2];
                if (256 == (256 & s)) return;
                qe(e);
                const i = Pe();
                try {
                    we(e),
                        (xe.lFrame.bindingIndex = t.bindingStartIndex),
                        null !== n && ni(t, e, n, 2, r);
                    const o = 3 == (3 & s);
                    if (!i)
                        if (o) {
                            const n = t.preOrderCheckHooks;
                            null !== n && $e(e, n, null);
                        } else {
                            const n = t.preOrderHooks;
                            null !== n && tn(e, n, 0, null), en(e, 0);
                        }
                    if (
                        ((function (t) {
                            for (let e = os(t); null !== e; e = as(e)) {
                                if (!e[2]) continue;
                                const t = e[9];
                                for (let e = 0; e < t.length; e++) {
                                    const n = t[e],
                                        r = n[3];
                                    0 == (1024 & n[2]) && Ce(r, 1),
                                        (n[2] |= 1024);
                                }
                            }
                        })(e),
                        (function (t) {
                            for (let e = os(t); null !== e; e = as(e))
                                for (let t = 10; t < e.length; t++) {
                                    const n = e[t],
                                        r = n[1];
                                    ve(n) && ti(r, n, r.template, n[8]);
                                }
                        })(e),
                        null !== t.contentQueries && Gs(t, e),
                        !i)
                    )
                        if (o) {
                            const n = t.contentCheckHooks;
                            null !== n && $e(e, n);
                        } else {
                            const n = t.contentHooks;
                            null !== n && tn(e, n, 1), en(e, 1);
                        }
                    !(function (t, e) {
                        const n = t.hostBindingOpCodes;
                        if (null !== n)
                            try {
                                for (let t = 0; t < n.length; t++) {
                                    const r = n[t];
                                    if (r < 0) Xe(~r);
                                    else {
                                        const s = r,
                                            i = n[++t],
                                            o = n[++t];
                                        Fe(i, s), o(2, e[s]);
                                    }
                                }
                            } finally {
                                Xe(-1);
                            }
                    })(t, e);
                    const a = t.components;
                    null !== a &&
                        (function (t, e) {
                            for (let n = 0; n < e.length; n++) xi(t, e[n]);
                        })(e, a);
                    const l = t.viewQuery;
                    if ((null !== l && Si(2, l, r), !i))
                        if (o) {
                            const n = t.viewCheckHooks;
                            null !== n && $e(e, n);
                        } else {
                            const n = t.viewHooks;
                            null !== n && tn(e, n, 2), en(e, 2);
                        }
                    !0 === t.firstUpdatePass && (t.firstUpdatePass = !1),
                        i || (e[2] &= -73),
                        1024 & e[2] && ((e[2] &= -1025), Ce(e[3], -1));
                } finally {
                    Ye();
                }
            }
            function ei(t, e, n, r) {
                const s = e[10],
                    i = !Pe(),
                    o = ye(e);
                try {
                    i && !o && s.begin && s.begin(),
                        o && $s(t, e, r),
                        ti(t, e, n, r);
                } finally {
                    i && !o && s.end && s.end();
                }
            }
            function ni(t, e, n, r, s) {
                const i = Ge();
                try {
                    Xe(-1),
                        2 & r && e.length > 20 && Ls(t, e, 20, Pe()),
                        n(r, s);
                } finally {
                    Xe(i);
                }
            }
            function ri(t, e, n) {
                if (Ut(e)) {
                    const r = e.directiveEnd;
                    for (let s = e.directiveStart; s < r; s++) {
                        const e = t.data[s];
                        e.contentQueries && e.contentQueries(1, n[s], s);
                    }
                }
            }
            function si(t, e, n) {
                _e() &&
                    ((function (t, e, n, r) {
                        const s = n.directiveStart,
                            i = n.directiveEnd;
                        t.firstCreatePass || mn(n, e), $r(r, e);
                        const o = n.initialInputs;
                        for (let a = s; a < i; a++) {
                            const r = t.data[a],
                                i = Gt(r);
                            i && vi(e, n, r);
                            const l = Tn(e, t, a, n);
                            $r(l, e),
                                null !== o && bi(0, a - s, l, r, 0, o),
                                i && (ge(n.index, e)[8] = l);
                        }
                    })(t, e, n, pe(n, e)),
                    128 == (128 & n.flags) &&
                        (function (t, e, n) {
                            const r = n.directiveStart,
                                s = n.directiveEnd,
                                i = n.index,
                                o = xe.lFrame.currentDirectiveIndex;
                            try {
                                Xe(i);
                                for (let n = r; n < s; n++) {
                                    const r = t.data[n],
                                        s = e[n];
                                    je(n),
                                        (null === r.hostBindings &&
                                            0 === r.hostVars &&
                                            null === r.hostAttrs) ||
                                            pi(r, s);
                                }
                            } finally {
                                Xe(-1), je(o);
                            }
                        })(t, e, n));
            }
            function ii(t, e, n = pe) {
                const r = e.localNames;
                if (null !== r) {
                    let s = e.index + 1;
                    for (let i = 0; i < r.length; i += 2) {
                        const o = r[i + 1],
                            a = -1 === o ? n(e, t) : t[o];
                        t[s++] = a;
                    }
                }
            }
            function oi(t) {
                const e = t.tView;
                return null === e || e.incompleteFirstPass
                    ? (t.tView = ai(
                          1,
                          null,
                          t.template,
                          t.decls,
                          t.vars,
                          t.directiveDefs,
                          t.pipeDefs,
                          t.viewQuery,
                          t.schemas,
                          t.consts
                      ))
                    : e;
            }
            function ai(t, e, n, r, s, i, o, a, l, c) {
                const u = 20 + r,
                    h = u + s,
                    d = (function (t, e) {
                        const n = [];
                        for (let r = 0; r < e; r++) n.push(r < t ? null : Bs);
                        return n;
                    })(u, h),
                    p = "function" == typeof c ? c() : c;
                return (d[1] = {
                    type: t,
                    blueprint: d,
                    template: n,
                    queries: null,
                    viewQuery: a,
                    declTNode: e,
                    data: d.slice().fill(null, u),
                    bindingStartIndex: u,
                    expandoStartIndex: h,
                    hostBindingOpCodes: null,
                    firstCreatePass: !0,
                    firstUpdatePass: !0,
                    staticViewQueries: !1,
                    staticContentQueries: !1,
                    preOrderHooks: null,
                    preOrderCheckHooks: null,
                    contentHooks: null,
                    contentCheckHooks: null,
                    viewHooks: null,
                    viewCheckHooks: null,
                    destroyHooks: null,
                    cleanup: null,
                    contentQueries: null,
                    components: null,
                    directiveRegistry: "function" == typeof i ? i() : i,
                    pipeRegistry: "function" == typeof o ? o() : o,
                    firstChild: null,
                    schemas: l,
                    consts: p,
                    incompleteFirstPass: !1,
                });
            }
            function li(t, e, n, r) {
                const s = Mi(e);
                null === n
                    ? s.push(r)
                    : (s.push(n),
                      t.firstCreatePass && Pi(t).push(r, s.length - 1));
            }
            function ci(t, e, n) {
                for (let r in t)
                    if (t.hasOwnProperty(r)) {
                        const s = t[r];
                        (n = null === n ? {} : n).hasOwnProperty(r)
                            ? n[r].push(e, s)
                            : (n[r] = [e, s]);
                    }
                return n;
            }
            function ui(t, e, n, r, s, i, o, a) {
                const l = pe(e, n);
                let c,
                    u = e.inputs;
                var h;
                !a && null != u && (c = u[r])
                    ? (Ni(t, n, c, r, s),
                      Zt(e) &&
                          (function (t, e) {
                              const n = ge(e, t);
                              16 & n[2] || (n[2] |= 64);
                          })(n, e.index))
                    : 3 & e.type &&
                      ((r =
                          "class" === (h = r)
                              ? "className"
                              : "for" === h
                              ? "htmlFor"
                              : "formaction" === h
                              ? "formAction"
                              : "innerHtml" === h
                              ? "innerHTML"
                              : "readonly" === h
                              ? "readOnly"
                              : "tabindex" === h
                              ? "tabIndex"
                              : h),
                      (s = null != o ? o(s, e.value || "", r) : s),
                      ce(i)
                          ? i.setProperty(l, r, s)
                          : an(r) ||
                            (l.setProperty ? l.setProperty(r, s) : (l[r] = s)));
            }
            function hi(t, e, n, r) {
                let s = !1;
                if (_e()) {
                    const i = (function (t, e, n) {
                            const r = t.directiveRegistry;
                            let s = null;
                            if (r)
                                for (let i = 0; i < r.length; i++) {
                                    const o = r[i];
                                    Fs(n, o.selectors, !1) &&
                                        (s || (s = []),
                                        wn(mn(n, e), t, o.type),
                                        Gt(o)
                                            ? (fi(t, n), s.unshift(o))
                                            : s.push(o));
                                }
                            return s;
                        })(t, e, n),
                        o = null === r ? null : { "": -1 };
                    if (null !== i) {
                        (s = !0), mi(n, t.data.length, i.length);
                        for (let t = 0; t < i.length; t++) {
                            const e = i[t];
                            e.providersResolver && e.providersResolver(e);
                        }
                        let r = !1,
                            a = !1,
                            l = Qs(t, e, i.length, null);
                        for (let s = 0; s < i.length; s++) {
                            const c = i[s];
                            (n.mergedAttrs = ln(n.mergedAttrs, c.hostAttrs)),
                                yi(t, n, e, l, c),
                                gi(l, c, o),
                                null !== c.contentQueries && (n.flags |= 8),
                                (null === c.hostBindings &&
                                    null === c.hostAttrs &&
                                    0 === c.hostVars) ||
                                    (n.flags |= 128);
                            const u = c.type.prototype;
                            !r &&
                                (u.ngOnChanges || u.ngOnInit || u.ngDoCheck) &&
                                ((
                                    t.preOrderHooks || (t.preOrderHooks = [])
                                ).push(n.index),
                                (r = !0)),
                                a ||
                                    (!u.ngOnChanges && !u.ngDoCheck) ||
                                    ((
                                        t.preOrderCheckHooks ||
                                        (t.preOrderCheckHooks = [])
                                    ).push(n.index),
                                    (a = !0)),
                                l++;
                        }
                        !(function (t, e) {
                            const n = e.directiveEnd,
                                r = t.data,
                                s = e.attrs,
                                i = [];
                            let o = null,
                                a = null;
                            for (let l = e.directiveStart; l < n; l++) {
                                const t = r[l],
                                    n = t.inputs,
                                    c = null === s || Ps(e) ? null : wi(n, s);
                                i.push(c),
                                    (o = ci(n, l, o)),
                                    (a = ci(t.outputs, l, a));
                            }
                            null !== o &&
                                (o.hasOwnProperty("class") && (e.flags |= 16),
                                o.hasOwnProperty("style") && (e.flags |= 32)),
                                (e.initialInputs = i),
                                (e.inputs = o),
                                (e.outputs = a);
                        })(t, n);
                    }
                    o &&
                        (function (t, e, n) {
                            if (e) {
                                const r = (t.localNames = []);
                                for (let t = 0; t < e.length; t += 2) {
                                    const s = n[e[t + 1]];
                                    if (null == s)
                                        throw new Jt(
                                            "301",
                                            `Export of name '${
                                                e[t + 1]
                                            }' not found!`
                                        );
                                    r.push(e[t], s);
                                }
                            }
                        })(n, r, o);
                }
                return (n.mergedAttrs = ln(n.mergedAttrs, n.attrs)), s;
            }
            function di(t, e, n, r, s, i) {
                const o = i.hostBindings;
                if (o) {
                    let n = t.hostBindingOpCodes;
                    null === n && (n = t.hostBindingOpCodes = []);
                    const i = ~e.index;
                    (function (t) {
                        let e = t.length;
                        for (; e > 0; ) {
                            const n = t[--e];
                            if ("number" == typeof n && n < 0) return n;
                        }
                        return 0;
                    })(n) != i && n.push(i),
                        n.push(r, s, o);
                }
            }
            function pi(t, e) {
                null !== t.hostBindings && t.hostBindings(1, e);
            }
            function fi(t, e) {
                (e.flags |= 2),
                    (t.components || (t.components = [])).push(e.index);
            }
            function gi(t, e, n) {
                if (n) {
                    if (e.exportAs)
                        for (let r = 0; r < e.exportAs.length; r++)
                            n[e.exportAs[r]] = t;
                    Gt(e) && (n[""] = t);
                }
            }
            function mi(t, e, n) {
                (t.flags |= 1),
                    (t.directiveStart = e),
                    (t.directiveEnd = e + n),
                    (t.providerIndexes = e);
            }
            function yi(t, e, n, r, s) {
                t.data[r] = s;
                const i = s.factory || (s.factory = Xt(s.type)),
                    o = new sn(i, Gt(s), null);
                (t.blueprint[r] = o),
                    (n[r] = o),
                    di(t, e, 0, r, Qs(t, n, s.hostVars, Bs), s);
            }
            function vi(t, e, n) {
                const r = pe(e, t),
                    s = oi(n),
                    i = t[10],
                    o = Ai(
                        t,
                        Xs(
                            t,
                            s,
                            null,
                            n.onPush ? 64 : 16,
                            r,
                            e,
                            i,
                            i.createRenderer(r, n),
                            null,
                            null
                        )
                    );
                t[e.index] = o;
            }
            function bi(t, e, n, r, s, i) {
                const o = i[e];
                if (null !== o) {
                    const t = r.setInput;
                    for (let e = 0; e < o.length; ) {
                        const s = o[e++],
                            i = o[e++],
                            a = o[e++];
                        null !== t ? r.setInput(n, a, s, i) : (n[i] = a);
                    }
                }
            }
            function wi(t, e) {
                let n = null,
                    r = 0;
                for (; r < e.length; ) {
                    const s = e[r];
                    if (0 !== s)
                        if (5 !== s) {
                            if ("number" == typeof s) break;
                            t.hasOwnProperty(s) &&
                                (null === n && (n = []),
                                n.push(s, t[s], e[r + 1])),
                                (r += 2);
                        } else r += 2;
                    else r += 4;
                }
                return n;
            }
            function Ci(t, e, n, r) {
                return new Array(t, !0, !1, e, null, 0, r, n, null, null);
            }
            function xi(t, e) {
                const n = ge(e, t);
                if (ve(n)) {
                    const t = n[1];
                    80 & n[2] ? ti(t, n, t.template, n[8]) : n[5] > 0 && _i(n);
                }
            }
            function _i(t) {
                for (let n = os(t); null !== n; n = as(n))
                    for (let t = 10; t < n.length; t++) {
                        const e = n[t];
                        if (1024 & e[2]) {
                            const t = e[1];
                            ti(t, e, t.template, e[8]);
                        } else e[5] > 0 && _i(e);
                    }
                const e = t[1].components;
                if (null !== e)
                    for (let n = 0; n < e.length; n++) {
                        const r = ge(e[n], t);
                        ve(r) && r[5] > 0 && _i(r);
                    }
            }
            function ki(t, e) {
                const n = ge(e, t),
                    r = n[1];
                !(function (t, e) {
                    for (let n = e.length; n < t.blueprint.length; n++)
                        e.push(t.blueprint[n]);
                })(r, n),
                    $s(r, n, n[8]);
            }
            function Ai(t, e) {
                return t[13] ? (t[14][4] = e) : (t[13] = e), (t[14] = e), e;
            }
            function Ei(t) {
                for (; t; ) {
                    t[2] |= 64;
                    const e = is(t);
                    if (0 != (512 & t[2]) && !e) return t;
                    t = e;
                }
                return null;
            }
            function Ii(t, e, n) {
                const r = e[10];
                r.begin && r.begin();
                try {
                    ti(t, e, t.template, n);
                } catch (s) {
                    throw (Ri(e, s), s);
                } finally {
                    r.end && r.end();
                }
            }
            function Ti(t) {
                !(function (t) {
                    for (let e = 0; e < t.components.length; e++) {
                        const n = t.components[e],
                            r = me(n),
                            s = r[1];
                        ei(s, r, s.template, n);
                    }
                })(t[8]);
            }
            function Si(t, e, n) {
                Be(0), e(t, n);
            }
            const Oi = (() => Promise.resolve(null))();
            function Mi(t) {
                return t[7] || (t[7] = []);
            }
            function Pi(t) {
                return t.cleanup || (t.cleanup = []);
            }
            function Ri(t, e) {
                const n = t[9],
                    r = n ? n.get(Qr, null) : null;
                r && r.handleError(e);
            }
            function Ni(t, e, n, r, s) {
                for (let i = 0; i < n.length; ) {
                    const o = n[i++],
                        a = n[i++],
                        l = e[o],
                        c = t.data[o];
                    null !== c.setInput ? c.setInput(l, s, r, a) : (l[a] = s);
                }
            }
            function Di(t, e, n) {
                let r = n ? t.styles : null,
                    s = n ? t.classes : null,
                    i = 0;
                if (null !== e)
                    for (let o = 0; o < e.length; o++) {
                        const t = e[o];
                        "number" == typeof t
                            ? (i = t)
                            : 1 == i
                            ? (s = tt(s, t))
                            : 2 == i && (r = tt(r, t + ": " + e[++o] + ";"));
                    }
                n ? (t.styles = r) : (t.stylesWithoutHost = r),
                    n ? (t.classes = s) : (t.classesWithoutHost = s);
            }
            const Vi = new Nn("INJECTOR", -1);
            class Fi {
                get(t, e = Qn) {
                    if (e === Qn) {
                        const e = new Error(
                            `NullInjectorError: No provider for ${$(t)}!`
                        );
                        throw ((e.name = "NullInjectorError"), e);
                    }
                    return e;
                }
            }
            const ji = new Nn("Set Injector scope."),
                zi = {},
                Bi = {},
                Hi = [];
            let Li;
            function qi() {
                return void 0 === Li && (Li = new Fi()), Li;
            }
            function Ki(t, e = null, n = null, r) {
                return new Wi(t, n, e || qi(), r);
            }
            class Wi {
                constructor(t, e, n, r = null) {
                    (this.parent = n),
                        (this.records = new Map()),
                        (this.injectorDefTypes = new Set()),
                        (this.onDestroy = new Set()),
                        (this._destroyed = !1);
                    const s = [];
                    e && jn(e, (n) => this.processProvider(n, t, e)),
                        jn([t], (t) => this.processInjectorType(t, [], s)),
                        this.records.set(Vi, Zi(void 0, this));
                    const i = this.records.get(ji);
                    (this.scope = null != i ? i.value : null),
                        (this.source =
                            r || ("object" == typeof t ? null : $(t)));
                }
                get destroyed() {
                    return this._destroyed;
                }
                destroy() {
                    this.assertNotDestroyed(), (this._destroyed = !0);
                    try {
                        this.onDestroy.forEach((t) => t.ngOnDestroy());
                    } finally {
                        this.records.clear(),
                            this.onDestroy.clear(),
                            this.injectorDefTypes.clear();
                    }
                }
                get(t, e = Qn, n = pt.Default) {
                    this.assertNotDestroyed();
                    const r = nr(this);
                    try {
                        if (!(n & pt.SkipSelf)) {
                            let e = this.records.get(t);
                            if (void 0 === e) {
                                const n =
                                    ("function" == typeof (s = t) ||
                                        ("object" == typeof s &&
                                            s instanceof Nn)) &&
                                    ot(t);
                                (e =
                                    n && this.injectableDefInScope(n)
                                        ? Zi(Ui(t), zi)
                                        : null),
                                    this.records.set(t, e);
                            }
                            if (null != e) return this.hydrate(t, e);
                        }
                        return (n & pt.Self ? qi() : this.parent).get(
                            t,
                            (e = n & pt.Optional && e === Qn ? null : e)
                        );
                    } catch (i) {
                        if ("NullInjectorError" === i.name) {
                            if (
                                ((i.ngTempTokenPath =
                                    i.ngTempTokenPath || []).unshift($(t)),
                                r)
                            )
                                throw i;
                            return (function (t, e, n, r) {
                                const s = t.ngTempTokenPath;
                                throw (
                                    (e.__source && s.unshift(e.__source),
                                    (t.message = (function (t, e, n, r = null) {
                                        t =
                                            t &&
                                            "\n" === t.charAt(0) &&
                                            "\u0275" == t.charAt(1)
                                                ? t.substr(2)
                                                : t;
                                        let s = $(e);
                                        if (Array.isArray(e))
                                            s = e.map($).join(" -> ");
                                        else if ("object" == typeof e) {
                                            let t = [];
                                            for (let n in e)
                                                if (e.hasOwnProperty(n)) {
                                                    let r = e[n];
                                                    t.push(
                                                        n +
                                                            ":" +
                                                            ("string" ==
                                                            typeof r
                                                                ? JSON.stringify(
                                                                      r
                                                                  )
                                                                : $(r))
                                                    );
                                                }
                                            s = `{${t.join(", ")}}`;
                                        }
                                        return `${n}${
                                            r ? "(" + r + ")" : ""
                                        }[${s}]: ${t.replace($n, "\n  ")}`;
                                    })("\n" + t.message, s, n, r)),
                                    (t.ngTokenPath = s),
                                    (t.ngTempTokenPath = null),
                                    t)
                                );
                            })(i, t, "R3InjectorError", this.source);
                        }
                        throw i;
                    } finally {
                        nr(r);
                    }
                    var s;
                }
                _resolveInjectorDefTypes() {
                    this.injectorDefTypes.forEach((t) => this.get(t));
                }
                toString() {
                    const t = [];
                    return (
                        this.records.forEach((e, n) => t.push($(n))),
                        `R3Injector[${t.join(", ")}]`
                    );
                }
                assertNotDestroyed() {
                    if (this._destroyed)
                        throw new Error("Injector has already been destroyed.");
                }
                processInjectorType(t, e, n) {
                    if (!(t = rt(t))) return !1;
                    let r = lt(t);
                    const s = (null == r && t.ngModule) || void 0,
                        i = void 0 === s ? t : s,
                        o = -1 !== n.indexOf(i);
                    if ((void 0 !== s && (r = lt(s)), null == r)) return !1;
                    if (null != r.imports && !o) {
                        let t;
                        n.push(i);
                        try {
                            jn(r.imports, (r) => {
                                this.processInjectorType(r, e, n) &&
                                    (void 0 === t && (t = []), t.push(r));
                            });
                        } finally {
                        }
                        if (void 0 !== t)
                            for (let e = 0; e < t.length; e++) {
                                const { ngModule: n, providers: r } = t[e];
                                jn(r, (t) =>
                                    this.processProvider(t, n, r || Hi)
                                );
                            }
                    }
                    this.injectorDefTypes.add(i),
                        this.records.set(i, Zi(r.factory, zi));
                    const a = r.providers;
                    if (null != a && !o) {
                        const e = t;
                        jn(a, (t) => this.processProvider(t, e, a));
                    }
                    return void 0 !== s && void 0 !== t.providers;
                }
                processProvider(t, e, n) {
                    let r = Gi((t = rt(t))) ? t : rt(t && t.provide);
                    const s = (function (t, e, n) {
                        return Yi(t)
                            ? Zi(void 0, t.useValue)
                            : Zi(
                                  (function (t, e, n) {
                                      let r;
                                      if (Gi(t)) {
                                          const e = rt(t);
                                          return Xt(e) || Ui(e);
                                      }
                                      if (Yi(t)) r = () => rt(t.useValue);
                                      else if ((s = t) && s.useFactory)
                                          r = () =>
                                              t.useFactory(...ir(t.deps || []));
                                      else if (
                                          (function (t) {
                                              return !(!t || !t.useExisting);
                                          })(t)
                                      )
                                          r = () => sr(rt(t.useExisting));
                                      else {
                                          const e = rt(
                                              t && (t.useClass || t.provide)
                                          );
                                          if (
                                              !(function (t) {
                                                  return !!t.deps;
                                              })(t)
                                          )
                                              return Xt(e) || Ui(e);
                                          r = () => new e(...ir(t.deps));
                                      }
                                      var s;
                                      return r;
                                  })(t),
                                  zi
                              );
                    })(t);
                    if (Gi(t) || !0 !== t.multi) this.records.get(r);
                    else {
                        let e = this.records.get(r);
                        e ||
                            ((e = Zi(void 0, zi, !0)),
                            (e.factory = () => ir(e.multi)),
                            this.records.set(r, e)),
                            (r = t),
                            e.multi.push(t);
                    }
                    this.records.set(r, s);
                }
                hydrate(t, e) {
                    var n;
                    return (
                        e.value === zi &&
                            ((e.value = Bi), (e.value = e.factory())),
                        "object" == typeof e.value &&
                            e.value &&
                            null !== (n = e.value) &&
                            "object" == typeof n &&
                            "function" == typeof n.ngOnDestroy &&
                            this.onDestroy.add(e.value),
                        e.value
                    );
                }
                injectableDefInScope(t) {
                    return (
                        !!t.providedIn &&
                        ("string" == typeof t.providedIn
                            ? "any" === t.providedIn ||
                              t.providedIn === this.scope
                            : this.injectorDefTypes.has(t.providedIn))
                    );
                }
            }
            function Ui(t) {
                const e = ot(t),
                    n = null !== e ? e.factory : Xt(t);
                if (null !== n) return n;
                const r = lt(t);
                if (null !== r) return r.factory;
                if (t instanceof Nn)
                    throw new Error(
                        `Token ${$(t)} is missing a \u0275prov definition.`
                    );
                if (t instanceof Function)
                    return (function (t) {
                        const e = t.length;
                        if (e > 0) {
                            const n = Hn(e, "?");
                            throw new Error(
                                `Can't resolve all parameters for ${$(
                                    t
                                )}: (${n.join(", ")}).`
                            );
                        }
                        const n = (function (t) {
                            const e = t && (t[ct] || t[ht]);
                            if (e) {
                                const n = (function (t) {
                                    if (t.hasOwnProperty("name")) return t.name;
                                    const e = ("" + t).match(
                                        /^function\s*([^\s(]+)/
                                    );
                                    return null === e ? "" : e[1];
                                })(t);
                                return (
                                    console.warn(
                                        `DEPRECATED: DI is instantiating a token "${n}" that inherits its @Injectable decorator but does not provide one itself.\nThis will become an error in a future version of Angular. Please add @Injectable() to the "${n}" class.`
                                    ),
                                    e
                                );
                            }
                            return null;
                        })(t);
                        return null !== n ? () => n.factory(t) : () => new t();
                    })(t);
                throw new Error("unreachable");
            }
            function Zi(t, e, n = !1) {
                return { factory: t, value: e, multi: n ? [] : void 0 };
            }
            function Yi(t) {
                return null !== t && "object" == typeof t && tr in t;
            }
            function Gi(t) {
                return "function" == typeof t;
            }
            const Xi = function (t, e, n) {
                return (function (t, e = null, n = null, r) {
                    const s = Ki(t, e, n, r);
                    return s._resolveInjectorDefTypes(), s;
                })({ name: n }, e, t, n);
            };
            let Ji = (() => {
                class t {
                    static create(t, e) {
                        return Array.isArray(t)
                            ? Xi(t, e, "")
                            : Xi(t.providers, t.parent, t.name || "");
                    }
                }
                return (
                    (t.THROW_IF_NOT_FOUND = Qn),
                    (t.NULL = new Fi()),
                    (t.ɵprov = st({
                        token: t,
                        providedIn: "any",
                        factory: () => sr(Vi),
                    })),
                    (t.__NG_ELEMENT_ID__ = -1),
                    t
                );
            })();
            function Qi(t, e) {
                Qe(me(t)[1], Ie());
            }
            let $i = null;
            function to() {
                if (!$i) {
                    const t = kt.Symbol;
                    if (t && t.iterator) $i = t.iterator;
                    else {
                        const t = Object.getOwnPropertyNames(Map.prototype);
                        for (let e = 0; e < t.length; ++e) {
                            const n = t[e];
                            "entries" !== n &&
                                "size" !== n &&
                                Map.prototype[n] === Map.prototype.entries &&
                                ($i = n);
                        }
                    }
                }
                return $i;
            }
            class eo {
                constructor(t) {
                    this.wrapped = t;
                }
                static wrap(t) {
                    return new eo(t);
                }
                static unwrap(t) {
                    return eo.isWrapped(t) ? t.wrapped : t;
                }
                static isWrapped(t) {
                    return t instanceof eo;
                }
            }
            function no(t) {
                return (
                    !!ro(t) &&
                    (Array.isArray(t) || (!(t instanceof Map) && to() in t))
                );
            }
            function ro(t) {
                return (
                    null !== t &&
                    ("function" == typeof t || "object" == typeof t)
                );
            }
            function so(t, e, n) {
                return (t[e] = n);
            }
            function io(t, e, n) {
                return !Object.is(t[e], n) && ((t[e] = n), !0);
            }
            function oo(t, e, n, r) {
                const s = ke();
                return (
                    io(s, De(), e) &&
                        (Ae(),
                        (function (t, e, n, r, s, i) {
                            const o = pe(t, e);
                            !(function (t, e, n, r, s, i, o) {
                                if (null == i)
                                    ce(t)
                                        ? t.removeAttribute(e, s, n)
                                        : e.removeAttribute(s);
                                else {
                                    const a =
                                        null == o ? Qt(i) : o(i, r || "", s);
                                    ce(t)
                                        ? t.setAttribute(e, s, a, n)
                                        : n
                                        ? e.setAttributeNS(n, s, a)
                                        : e.setAttribute(s, a);
                                }
                            })(e[11], o, i, t.value, n, r, s);
                        })(Je(), s, t, e, n, r)),
                    oo
                );
            }
            function ao(t, e, n, r) {
                return io(t, De(), n) ? e + Qt(n) + r : Bs;
            }
            function lo(t, e, n, r, s, i, o, a) {
                const l = ke(),
                    c = Ae(),
                    u = t + 20,
                    h = c.firstCreatePass
                        ? (function (t, e, n, r, s, i, o, a, l) {
                              const c = e.consts,
                                  u = Js(e, t, 4, o || null, be(c, a));
                              hi(e, n, u, be(c, l)), Qe(e, u);
                              const h = (u.tViews = ai(
                                  2,
                                  u,
                                  r,
                                  s,
                                  i,
                                  e.directiveRegistry,
                                  e.pipeRegistry,
                                  null,
                                  e.schemas,
                                  c
                              ));
                              return (
                                  null !== e.queries &&
                                      (e.queries.template(e, u),
                                      (h.queries = e.queries.embeddedTView(u))),
                                  u
                              );
                          })(u, c, l, e, n, r, s, i, o)
                        : c.data[u];
                Se(h, !1);
                const d = l[11].createComment("");
                xs(c, l, d, h),
                    $r(d, l),
                    Ai(l, (l[u] = Ci(d, l, d, h))),
                    Yt(h) && si(c, l, h),
                    null != o && ii(l, h, a);
            }
            function co(t) {
                return t.length > 1
                    ? " (" +
                          (function (t) {
                              const e = [];
                              for (let n = 0; n < t.length; ++n) {
                                  if (e.indexOf(t[n]) > -1)
                                      return e.push(t[n]), e;
                                  e.push(t[n]);
                              }
                              return e;
                          })(t.slice().reverse())
                              .map((t) => $(t.token))
                              .join(" -> ") +
                          ")"
                    : "";
            }
            function uo(t, e, n, r) {
                const s = [e],
                    i = n(s),
                    o = r
                        ? (function (t, e) {
                              const n = `${t} caused by: ${
                                      e instanceof Error ? e.message : e
                                  }`,
                                  r = Error(n);
                              return (r.ngOriginalError = e), r;
                          })(i, r)
                        : Error(i);
                return (
                    (o.addKey = ho),
                    (o.keys = s),
                    (o.injectors = [t]),
                    (o.constructResolvingMessage = n),
                    (o.ngOriginalError = r),
                    o
                );
            }
            function ho(t, e) {
                this.injectors.push(t),
                    this.keys.push(e),
                    (this.message = this.constructResolvingMessage(this.keys));
            }
            function po(t, e) {
                const n = [];
                for (let r = 0, s = e.length; r < s; r++) {
                    const t = e[r];
                    n.push(t && 0 != t.length ? t.map($).join(" ") : "?");
                }
                return Error(
                    "Cannot resolve all parameters for '" +
                        $(t) +
                        "'(" +
                        n.join(", ") +
                        "). Make sure that all the parameters are decorated with Inject or have valid type annotations and that '" +
                        $(t) +
                        "' is decorated with Injectable."
                );
            }
            class fo {
                constructor(t, e) {
                    if (((this.token = t), (this.id = e), !t))
                        throw new Error("Token must be defined!");
                    this.displayName = $(this.token);
                }
                static get(t) {
                    return mo.get(rt(t));
                }
                static get numberOfKeys() {
                    return mo.numberOfKeys;
                }
            }
            class go {
                constructor() {
                    this._allKeys = new Map();
                }
                get(t) {
                    if (t instanceof fo) return t;
                    if (this._allKeys.has(t)) return this._allKeys.get(t);
                    const e = new fo(t, fo.numberOfKeys);
                    return this._allKeys.set(t, e), e;
                }
                get numberOfKeys() {
                    return this._allKeys.size;
                }
            }
            const mo = new go();
            class yo {
                constructor(t) {
                    this.reflectionCapabilities = t;
                }
                updateCapabilities(t) {
                    this.reflectionCapabilities = t;
                }
                factory(t) {
                    return this.reflectionCapabilities.factory(t);
                }
                parameters(t) {
                    return this.reflectionCapabilities.parameters(t);
                }
                annotations(t) {
                    return this.reflectionCapabilities.annotations(t);
                }
                propMetadata(t) {
                    return this.reflectionCapabilities.propMetadata(t);
                }
                hasLifecycleHook(t, e) {
                    return this.reflectionCapabilities.hasLifecycleHook(t, e);
                }
                getter(t) {
                    return this.reflectionCapabilities.getter(t);
                }
                setter(t) {
                    return this.reflectionCapabilities.setter(t);
                }
                method(t) {
                    return this.reflectionCapabilities.method(t);
                }
                importUri(t) {
                    return this.reflectionCapabilities.importUri(t);
                }
                resourceUri(t) {
                    return this.reflectionCapabilities.resourceUri(t);
                }
                resolveIdentifier(t, e, n, r) {
                    return this.reflectionCapabilities.resolveIdentifier(
                        t,
                        e,
                        n,
                        r
                    );
                }
                resolveEnum(t, e) {
                    return this.reflectionCapabilities.resolveEnum(t, e);
                }
            }
            const vo = new yo(new Gn());
            class bo {
                constructor(t, e, n) {
                    (this.key = t), (this.optional = e), (this.visibility = n);
                }
                static fromKey(t) {
                    return new bo(t, !1, null);
                }
            }
            const wo = [];
            class Co {
                constructor(t, e, n) {
                    (this.key = t),
                        (this.resolvedFactories = e),
                        (this.multiProvider = n),
                        (this.resolvedFactory = this.resolvedFactories[0]);
                }
            }
            class xo {
                constructor(t, e) {
                    (this.factory = t), (this.dependencies = e);
                }
            }
            function _o(t) {
                let e, n;
                if (t.useClass) {
                    const r = rt(t.useClass);
                    (e = vo.factory(r)), (n = Io(r));
                } else
                    t.useExisting
                        ? ((e = (t) => t),
                          (n = [bo.fromKey(fo.get(t.useExisting))]))
                        : t.useFactory
                        ? ((e = t.useFactory),
                          (n = (function (t, e) {
                              if (e) {
                                  const n = e.map((t) => [t]);
                                  return e.map((e) => To(t, e, n));
                              }
                              return Io(t);
                          })(t.useFactory, t.deps)))
                        : ((e = () => t.useValue), (n = wo));
                return new xo(e, n);
            }
            function ko(t) {
                return new Co(fo.get(t.provide), [_o(t)], t.multi || !1);
            }
            function Ao(t) {
                const e = (function (t, e) {
                    for (let n = 0; n < t.length; n++) {
                        const r = t[n],
                            s = e.get(r.key.id);
                        if (s) {
                            if (r.multiProvider !== s.multiProvider)
                                throw Error(
                                    `Cannot mix multi providers and regular providers, got: ${s} ${r}`
                                );
                            if (r.multiProvider)
                                for (
                                    let t = 0;
                                    t < r.resolvedFactories.length;
                                    t++
                                )
                                    s.resolvedFactories.push(
                                        r.resolvedFactories[t]
                                    );
                            else e.set(r.key.id, r);
                        } else {
                            let t;
                            (t = r.multiProvider
                                ? new Co(
                                      r.key,
                                      r.resolvedFactories.slice(),
                                      r.multiProvider
                                  )
                                : r),
                                e.set(r.key.id, t);
                        }
                    }
                    return e;
                })(Eo(t, []).map(ko), new Map());
                return Array.from(e.values());
            }
            function Eo(t, e) {
                return (
                    t.forEach((t) => {
                        if (t instanceof Dn)
                            e.push({ provide: t, useClass: t });
                        else if (
                            t &&
                            "object" == typeof t &&
                            void 0 !== t.provide
                        )
                            e.push(t);
                        else {
                            if (!Array.isArray(t))
                                throw Error(
                                    `Invalid provider - only instances of Provider and Type are allowed, got: ${t}`
                                );
                            Eo(t, e);
                        }
                    }),
                    e
                );
            }
            function Io(t) {
                const e = vo.parameters(t);
                if (!e) return [];
                if (e.some((t) => null == t)) throw po(t, e);
                return e.map((n) => To(t, n, e));
            }
            function To(t, e, n) {
                let r = null,
                    s = !1;
                if (!Array.isArray(e))
                    return So(e instanceof ar ? e.token : e, s, null);
                let i = null;
                for (let o = 0; o < e.length; ++o) {
                    const t = e[o];
                    t instanceof Dn
                        ? (r = t)
                        : t instanceof ar
                        ? (r = t.token)
                        : t instanceof lr
                        ? (s = !0)
                        : t instanceof cr || t instanceof ur
                        ? (i = t)
                        : t instanceof Nn && (r = t);
                }
                if (((r = rt(r)), null != r)) return So(r, s, i);
                throw po(t, n);
            }
            function So(t, e, n) {
                return new bo(fo.get(t), e, n);
            }
            const Oo = {};
            class Mo {
                static resolve(t) {
                    return Ao(t);
                }
                static resolveAndCreate(t, e) {
                    const n = Mo.resolve(t);
                    return Mo.fromResolvedProviders(n, e);
                }
                static fromResolvedProviders(t, e) {
                    return new Po(t, e);
                }
            }
            let Po = (() => {
                class t {
                    constructor(t, e) {
                        (this._constructionCounter = 0),
                            (this._providers = t),
                            (this.parent = e || null);
                        const n = t.length;
                        (this.keyIds = []), (this.objs = []);
                        for (let r = 0; r < n; r++)
                            (this.keyIds[r] = t[r].key.id), (this.objs[r] = Oo);
                    }
                    get(t, e = Qn) {
                        return this._getByKey(fo.get(t), null, e);
                    }
                    resolveAndCreateChild(t) {
                        const e = Mo.resolve(t);
                        return this.createChildFromResolved(e);
                    }
                    createChildFromResolved(e) {
                        const n = new t(e);
                        return (n.parent = this), n;
                    }
                    resolveAndInstantiate(t) {
                        return this.instantiateResolved(Mo.resolve([t])[0]);
                    }
                    instantiateResolved(t) {
                        return this._instantiateProvider(t);
                    }
                    getProviderAtIndex(t) {
                        if (t < 0 || t >= this._providers.length)
                            throw (function (t) {
                                return Error(`Index ${t} is out-of-bounds.`);
                            })(t);
                        return this._providers[t];
                    }
                    _new(t) {
                        if (
                            this._constructionCounter++ >
                            this._getMaxNumberOfObjects()
                        )
                            throw uo(this, t.key, function (t) {
                                return `Cannot instantiate cyclic dependency!${co(
                                    t
                                )}`;
                            });
                        return this._instantiateProvider(t);
                    }
                    _getMaxNumberOfObjects() {
                        return this.objs.length;
                    }
                    _instantiateProvider(t) {
                        if (t.multiProvider) {
                            const e = [];
                            for (let n = 0; n < t.resolvedFactories.length; ++n)
                                e[n] = this._instantiate(
                                    t,
                                    t.resolvedFactories[n]
                                );
                            return e;
                        }
                        return this._instantiate(t, t.resolvedFactories[0]);
                    }
                    _instantiate(t, e) {
                        const n = e.factory;
                        let r, s;
                        try {
                            r = e.dependencies.map((t) =>
                                this._getByReflectiveDependency(t)
                            );
                        } catch (o) {
                            throw (o.addKey && o.addKey(this, t.key), o);
                        }
                        try {
                            s = n(...r);
                        } catch (o) {
                            throw uo(
                                this,
                                t.key,
                                function (t) {
                                    const e = $(t[0].token);
                                    return `${
                                        i.message
                                    }: Error during instantiation of ${e}!${co(
                                        t
                                    )}.`;
                                },
                                (i = o)
                            );
                        }
                        var i;
                        return s;
                    }
                    _getByReflectiveDependency(t) {
                        return this._getByKey(
                            t.key,
                            t.visibility,
                            t.optional ? null : Qn
                        );
                    }
                    _getByKey(e, n, r) {
                        return e === t.INJECTOR_KEY
                            ? this
                            : n instanceof cr
                            ? this._getByKeySelf(e, r)
                            : this._getByKeyDefault(e, r, n);
                    }
                    _getObjByKeyId(t) {
                        for (let e = 0; e < this.keyIds.length; e++)
                            if (this.keyIds[e] === t)
                                return (
                                    this.objs[e] === Oo &&
                                        (this.objs[e] = this._new(
                                            this._providers[e]
                                        )),
                                    this.objs[e]
                                );
                        return Oo;
                    }
                    _throwOrNull(t, e) {
                        if (e !== Qn) return e;
                        throw (function (t, e) {
                            return uo(t, e, function (t) {
                                return `No provider for ${$(
                                    t[0].token
                                )}!${co(t)}`;
                            });
                        })(this, t);
                    }
                    _getByKeySelf(t, e) {
                        const n = this._getObjByKeyId(t.id);
                        return n !== Oo ? n : this._throwOrNull(t, e);
                    }
                    _getByKeyDefault(e, n, r) {
                        let s;
                        for (
                            s = r instanceof ur ? this.parent : this;
                            s instanceof t;

                        ) {
                            const t = s,
                                n = t._getObjByKeyId(e.id);
                            if (n !== Oo) return n;
                            s = t.parent;
                        }
                        return null !== s
                            ? s.get(e.token, n)
                            : this._throwOrNull(e, n);
                    }
                    get displayName() {
                        return `ReflectiveInjector(providers: [${(function (
                            t,
                            e
                        ) {
                            const n = [];
                            for (let r = 0; r < t._providers.length; ++r)
                                n[r] =
                                    ' "' +
                                    t.getProviderAtIndex(r).key.displayName +
                                    '" ';
                            return n;
                        })(this).join(", ")}])`;
                    }
                    toString() {
                        return this.displayName;
                    }
                }
                return (t.INJECTOR_KEY = fo.get(Ji)), t;
            })();
            function Ro(t, e = pt.Default) {
                const n = ke();
                return null === n ? sr(t, e) : _n(Ie(), n, rt(t), e);
            }
            function No(t, e, n) {
                const r = ke();
                return (
                    io(r, De(), e) && ui(Ae(), Je(), r, t, e, r[11], n, !1), No
                );
            }
            function Do(t, e, n, r, s) {
                const i = s ? "class" : "style";
                Ni(t, n, e.inputs[i], i, r);
            }
            function Vo(t, e, n, r) {
                const s = ke(),
                    i = Ae(),
                    o = 20 + t,
                    a = s[11],
                    l = (s[o] = us(a, e, xe.lFrame.currentNamespace)),
                    c = i.firstCreatePass
                        ? (function (t, e, n, r, s, i, o) {
                              const a = e.consts,
                                  l = Js(e, t, 2, s, be(a, i));
                              return (
                                  hi(e, n, l, be(a, o)),
                                  null !== l.attrs && Di(l, l.attrs, !1),
                                  null !== l.mergedAttrs &&
                                      Di(l, l.mergedAttrs, !0),
                                  null !== e.queries &&
                                      e.queries.elementStart(e, l),
                                  l
                              );
                          })(o, i, s, 0, e, n, r)
                        : i.data[o];
                Se(c, !0);
                const u = c.mergedAttrs;
                null !== u && on(a, l, u);
                const h = c.classes;
                null !== h && Ss(a, l, h);
                const d = c.styles;
                null !== d && Ts(a, l, d),
                    64 != (64 & c.flags) && xs(i, s, l, c),
                    0 === xe.lFrame.elementDepthCount && $r(l, s),
                    xe.lFrame.elementDepthCount++,
                    Yt(c) && (si(i, s, c), ri(i, c, s)),
                    null !== r && ii(s, c);
            }
            function Fo() {
                let t = Ie();
                Oe() ? Me() : ((t = t.parent), Se(t, !1));
                const e = t;
                xe.lFrame.elementDepthCount--;
                const n = Ae();
                n.firstCreatePass &&
                    (Qe(n, t), Ut(t) && n.queries.elementEnd(t)),
                    null != e.classesWithoutHost &&
                        (function (t) {
                            return 0 != (16 & t.flags);
                        })(e) &&
                        Do(n, e, ke(), e.classesWithoutHost, !0),
                    null != e.stylesWithoutHost &&
                        (function (t) {
                            return 0 != (32 & t.flags);
                        })(e) &&
                        Do(n, e, ke(), e.stylesWithoutHost, !1);
            }
            function jo(t, e, n, r) {
                Vo(t, e, n, r), Fo();
            }
            function zo(t, e, n) {
                const r = ke(),
                    s = Ae(),
                    i = t + 20,
                    o = s.firstCreatePass
                        ? (function (t, e, n, r, s) {
                              const i = e.consts,
                                  o = be(i, r),
                                  a = Js(e, t, 8, "ng-container", o);
                              return (
                                  null !== o && Di(a, o, !0),
                                  hi(e, n, a, be(i, s)),
                                  null !== e.queries &&
                                      e.queries.elementStart(e, a),
                                  a
                              );
                          })(i, s, r, e, n)
                        : s.data[i];
                Se(o, !0);
                const a = (r[i] = r[11].createComment(""));
                xs(s, r, a, o),
                    $r(a, r),
                    Yt(o) && (si(s, r, o), ri(s, o, r)),
                    null != n && ii(r, o);
            }
            function Bo() {
                let t = Ie();
                const e = Ae();
                Oe() ? Me() : ((t = t.parent), Se(t, !1)),
                    e.firstCreatePass &&
                        (Qe(e, t), Ut(t) && e.queries.elementEnd(t));
            }
            function Ho() {
                return ke();
            }
            function Lo(t) {
                return !!t && "function" == typeof t.then;
            }
            function qo(t, e, n = !1, r) {
                const s = ke(),
                    i = Ae(),
                    o = Ie();
                return (
                    (function (t, e, n, r, s, i, o = !1, a) {
                        const l = Yt(r),
                            c = t.firstCreatePass && Pi(t),
                            u = Mi(e);
                        let h = !0;
                        if (3 & r.type) {
                            const d = pe(r, e),
                                p = a ? a(d) : At,
                                f = p.target || d,
                                g = u.length,
                                m = a
                                    ? (t) => a(he(t[r.index])).target
                                    : r.index;
                            if (ce(n)) {
                                let o = null;
                                if (
                                    (!a &&
                                        l &&
                                        (o = (function (t, e, n, r) {
                                            const s = t.cleanup;
                                            if (null != s)
                                                for (
                                                    let i = 0;
                                                    i < s.length - 1;
                                                    i += 2
                                                ) {
                                                    const t = s[i];
                                                    if (
                                                        t === n &&
                                                        s[i + 1] === r
                                                    ) {
                                                        const t = e[7],
                                                            n = s[i + 2];
                                                        return t.length > n
                                                            ? t[n]
                                                            : null;
                                                    }
                                                    "string" == typeof t &&
                                                        (i += 2);
                                                }
                                            return null;
                                        })(t, e, s, r.index)),
                                    null !== o)
                                )
                                    ((
                                        o.__ngLastListenerFn__ || o
                                    ).__ngNextListenerFn__ = i),
                                        (o.__ngLastListenerFn__ = i),
                                        (h = !1);
                                else {
                                    i = Wo(r, e, i, !1);
                                    const t = n.listen(p.name || f, s, i);
                                    u.push(i, t), c && c.push(s, m, g, g + 1);
                                }
                            } else
                                (i = Wo(r, e, i, !0)),
                                    f.addEventListener(s, i, o),
                                    u.push(i),
                                    c && c.push(s, m, g, o);
                        } else i = Wo(r, e, i, !1);
                        const d = r.outputs;
                        let p;
                        if (h && null !== d && (p = d[s])) {
                            const t = p.length;
                            if (t)
                                for (let n = 0; n < t; n += 2) {
                                    const t = e[p[n]][p[n + 1]].subscribe(i),
                                        o = u.length;
                                    u.push(i, t),
                                        c && c.push(s, r.index, o, -(o + 1));
                                }
                        }
                    })(i, s, s[11], o, t, e, n, r),
                    qo
                );
            }
            function Ko(t, e, n) {
                try {
                    return !1 !== e(n);
                } catch (r) {
                    return Ri(t, r), !1;
                }
            }
            function Wo(t, e, n, r) {
                return function s(i) {
                    if (i === Function) return n;
                    const o = 2 & t.flags ? ge(t.index, e) : e;
                    0 == (32 & e[2]) && Ei(o);
                    let a = Ko(e, n, i),
                        l = s.__ngNextListenerFn__;
                    for (; l; )
                        (a = Ko(e, l, i) && a), (l = l.__ngNextListenerFn__);
                    return (
                        r &&
                            !1 === a &&
                            (i.preventDefault(), (i.returnValue = !1)),
                        a
                    );
                };
            }
            function Uo(t = 1) {
                return (function (t) {
                    return (xe.lFrame.contextLView = (function (t, e) {
                        for (; t > 0; ) (e = e[15]), t--;
                        return e;
                    })(t, xe.lFrame.contextLView))[8];
                })(t);
            }
            const Zo = [];
            function Yo(t, e, n, r, s) {
                const i = t[n + 1],
                    o = null === e;
                let a = r ? Ks(i) : Us(i),
                    l = !1;
                for (; 0 !== a && (!1 === l || o); ) {
                    const n = t[a + 1];
                    Go(t[a], e) && ((l = !0), (t[a + 1] = r ? Ys(n) : Ws(n))),
                        (a = r ? Ks(n) : Us(n));
                }
                l && (t[n + 1] = r ? Ws(i) : Ys(i));
            }
            function Go(t, e) {
                return (
                    null === t ||
                    null == e ||
                    (Array.isArray(t) ? t[1] : t) === e ||
                    (!(!Array.isArray(t) || "string" != typeof e) &&
                        Kn(t, e) >= 0)
                );
            }
            const Xo = { textEnd: 0, key: 0, keyEnd: 0, value: 0, valueEnd: 0 };
            function Jo(t) {
                return t.substring(Xo.key, Xo.keyEnd);
            }
            function Qo(t, e) {
                const n = Xo.textEnd;
                return n === e
                    ? -1
                    : ((e = Xo.keyEnd =
                          (function (t, e, n) {
                              for (; e < n && t.charCodeAt(e) > 32; ) e++;
                              return e;
                          })(t, (Xo.key = e), n)),
                      $o(t, e, n));
            }
            function $o(t, e, n) {
                for (; e < n && t.charCodeAt(e) <= 32; ) e++;
                return e;
            }
            function ta(t, e, n) {
                return sa(t, e, n, !1), ta;
            }
            function ea(t, e) {
                return sa(t, e, null, !0), ea;
            }
            function na(t) {
                ia(Ln, ra, t, !0);
            }
            function ra(t, e) {
                for (
                    let n = (function (t) {
                        return (
                            (function (t) {
                                (Xo.key = 0),
                                    (Xo.keyEnd = 0),
                                    (Xo.value = 0),
                                    (Xo.valueEnd = 0),
                                    (Xo.textEnd = t.length);
                            })(t),
                            Qo(t, $o(t, 0, Xo.textEnd))
                        );
                    })(e);
                    n >= 0;
                    n = Qo(e, n)
                )
                    Ln(t, Jo(e), !0);
            }
            function sa(t, e, n, r) {
                const s = ke(),
                    i = Ae(),
                    o = Ve(2);
                i.firstUpdatePass && aa(i, t, o, r),
                    e !== Bs &&
                        io(s, o, e) &&
                        ua(
                            i,
                            i.data[Ge()],
                            s,
                            s[11],
                            t,
                            (s[o + 1] = (function (t, e) {
                                return (
                                    null == t ||
                                        ("string" == typeof e
                                            ? (t += e)
                                            : "object" == typeof t &&
                                              (t = $(Cr(t)))),
                                    t
                                );
                            })(e, n)),
                            r,
                            o
                        );
            }
            function ia(t, e, n, r) {
                const s = Ae(),
                    i = Ve(2);
                s.firstUpdatePass && aa(s, null, i, r);
                const o = ke();
                if (n !== Bs && io(o, i, n)) {
                    const a = s.data[Ge()];
                    if (pa(a, r) && !oa(s, i)) {
                        let t = r ? a.classesWithoutHost : a.stylesWithoutHost;
                        null !== t && (n = tt(t, n || "")), Do(s, a, o, n, r);
                    } else
                        !(function (t, e, n, r, s, i, o, a) {
                            s === Bs && (s = Zo);
                            let l = 0,
                                c = 0,
                                u = 0 < s.length ? s[0] : null,
                                h = 0 < i.length ? i[0] : null;
                            for (; null !== u || null !== h; ) {
                                const d = l < s.length ? s[l + 1] : void 0,
                                    p = c < i.length ? i[c + 1] : void 0;
                                let f,
                                    g = null;
                                u === h
                                    ? ((l += 2),
                                      (c += 2),
                                      d !== p && ((g = h), (f = p)))
                                    : null === h || (null !== u && u < h)
                                    ? ((l += 2), (g = u))
                                    : ((c += 2), (g = h), (f = p)),
                                    null !== g && ua(t, e, n, r, g, f, o, a),
                                    (u = l < s.length ? s[l] : null),
                                    (h = c < i.length ? i[c] : null);
                            }
                        })(
                            s,
                            a,
                            o,
                            o[11],
                            o[i + 1],
                            (o[i + 1] = (function (t, e, n) {
                                if (null == n || "" === n) return Zo;
                                const r = [],
                                    s = Cr(n);
                                if (Array.isArray(s))
                                    for (let i = 0; i < s.length; i++)
                                        t(r, s[i], !0);
                                else if ("object" == typeof s)
                                    for (const i in s)
                                        s.hasOwnProperty(i) && t(r, i, s[i]);
                                else "string" == typeof s && e(r, s);
                                return r;
                            })(t, e, n)),
                            r,
                            i
                        );
                }
            }
            function oa(t, e) {
                return e >= t.expandoStartIndex;
            }
            function aa(t, e, n, r) {
                const s = t.data;
                if (null === s[n + 1]) {
                    const i = s[Ge()],
                        o = oa(t, n);
                    pa(i, r) && null === e && !o && (e = !1),
                        (e = (function (t, e, n, r) {
                            const s = (function (t) {
                                const e = xe.lFrame.currentDirectiveIndex;
                                return -1 === e ? null : t[e];
                            })(t);
                            let i = r ? e.residualClasses : e.residualStyles;
                            if (null === s)
                                0 === (r ? e.classBindings : e.styleBindings) &&
                                    ((n = ca(
                                        (n = la(null, t, e, n, r)),
                                        e.attrs,
                                        r
                                    )),
                                    (i = null));
                            else {
                                const o = e.directiveStylingLast;
                                if (-1 === o || t[o] !== s)
                                    if (((n = la(s, t, e, n, r)), null === i)) {
                                        let n = (function (t, e, n) {
                                            const r = n
                                                ? e.classBindings
                                                : e.styleBindings;
                                            if (0 !== Us(r)) return t[Ks(r)];
                                        })(t, e, r);
                                        void 0 !== n &&
                                            Array.isArray(n) &&
                                            ((n = la(null, t, e, n[1], r)),
                                            (n = ca(n, e.attrs, r)),
                                            (function (t, e, n, r) {
                                                t[
                                                    Ks(
                                                        n
                                                            ? e.classBindings
                                                            : e.styleBindings
                                                    )
                                                ] = r;
                                            })(t, e, r, n));
                                    } else
                                        i = (function (t, e, n) {
                                            let r;
                                            const s = e.directiveEnd;
                                            for (
                                                let i =
                                                    1 + e.directiveStylingLast;
                                                i < s;
                                                i++
                                            )
                                                r = ca(r, t[i].hostAttrs, n);
                                            return ca(r, e.attrs, n);
                                        })(t, e, r);
                            }
                            return (
                                void 0 !== i &&
                                    (r
                                        ? (e.residualClasses = i)
                                        : (e.residualStyles = i)),
                                n
                            );
                        })(s, i, e, r)),
                        (function (t, e, n, r, s, i) {
                            let o = i ? e.classBindings : e.styleBindings,
                                a = Ks(o),
                                l = Us(o);
                            t[r] = n;
                            let c,
                                u = !1;
                            if (Array.isArray(n)) {
                                const t = n;
                                (c = t[1]),
                                    (null === c || Kn(t, c) > 0) && (u = !0);
                            } else c = n;
                            if (s)
                                if (0 !== l) {
                                    const e = Ks(t[a + 1]);
                                    (t[r + 1] = qs(e, a)),
                                        0 !== e && (t[e + 1] = Zs(t[e + 1], r)),
                                        (t[a + 1] =
                                            (131071 & t[a + 1]) | (r << 17));
                                } else
                                    (t[r + 1] = qs(a, 0)),
                                        0 !== a && (t[a + 1] = Zs(t[a + 1], r)),
                                        (a = r);
                            else
                                (t[r + 1] = qs(l, 0)),
                                    0 === a
                                        ? (a = r)
                                        : (t[l + 1] = Zs(t[l + 1], r)),
                                    (l = r);
                            u && (t[r + 1] = Ws(t[r + 1])),
                                Yo(t, c, r, !0),
                                Yo(t, c, r, !1),
                                (function (t, e, n, r, s) {
                                    const i = s
                                        ? t.residualClasses
                                        : t.residualStyles;
                                    null != i &&
                                        "string" == typeof e &&
                                        Kn(i, e) >= 0 &&
                                        (n[r + 1] = Ys(n[r + 1]));
                                })(e, c, t, r, i),
                                (o = qs(a, l)),
                                i
                                    ? (e.classBindings = o)
                                    : (e.styleBindings = o);
                        })(s, i, e, n, o, r);
                }
            }
            function la(t, e, n, r, s) {
                let i = null;
                const o = n.directiveEnd;
                let a = n.directiveStylingLast;
                for (
                    -1 === a ? (a = n.directiveStart) : a++;
                    a < o && ((i = e[a]), (r = ca(r, i.hostAttrs, s)), i !== t);

                )
                    a++;
                return null !== t && (n.directiveStylingLast = a), r;
            }
            function ca(t, e, n) {
                const r = n ? 1 : 2;
                let s = -1;
                if (null !== e)
                    for (let i = 0; i < e.length; i++) {
                        const o = e[i];
                        "number" == typeof o
                            ? (s = o)
                            : s === r &&
                              (Array.isArray(t) ||
                                  (t = void 0 === t ? [] : ["", t]),
                              Ln(t, o, !!n || e[++i]));
                    }
                return void 0 === t ? null : t;
            }
            function ua(t, e, n, r, s, i, o, a) {
                if (!(3 & e.type)) return;
                const l = t.data,
                    c = l[a + 1];
                da(1 == (1 & c) ? ha(l, e, n, s, Us(c), o) : void 0) ||
                    (da(i) || (2 == (2 & c) && (i = ha(l, null, n, s, a, o))),
                    (function (t, e, n, r, s) {
                        const i = ce(t);
                        if (e)
                            s
                                ? i
                                    ? t.addClass(n, r)
                                    : n.classList.add(r)
                                : i
                                ? t.removeClass(n, r)
                                : n.classList.remove(r);
                        else {
                            let e =
                                -1 === r.indexOf("-") ? void 0 : rs.DashCase;
                            if (null == s)
                                i
                                    ? t.removeStyle(n, r, e)
                                    : n.style.removeProperty(r);
                            else {
                                const o =
                                    "string" == typeof s &&
                                    s.endsWith("!important");
                                o &&
                                    ((s = s.slice(0, -10)),
                                    (e |= rs.Important)),
                                    i
                                        ? t.setStyle(n, r, s, e)
                                        : n.style.setProperty(
                                              r,
                                              s,
                                              o ? "important" : ""
                                          );
                            }
                        }
                    })(r, o, de(Ge(), n), s, i));
            }
            function ha(t, e, n, r, s, i) {
                const o = null === e;
                let a;
                for (; s > 0; ) {
                    const e = t[s],
                        i = Array.isArray(e),
                        l = i ? e[1] : e,
                        c = null === l;
                    let u = n[s + 1];
                    u === Bs && (u = c ? Zo : void 0);
                    let h = c ? qn(u, r) : l === r ? u : void 0;
                    if ((i && !da(h) && (h = qn(e, r)), da(h) && ((a = h), o)))
                        return a;
                    const d = t[s + 1];
                    s = o ? Ks(d) : Us(d);
                }
                if (null !== e) {
                    let t = i ? e.residualClasses : e.residualStyles;
                    null != t && (a = qn(t, r));
                }
                return a;
            }
            function da(t) {
                return void 0 !== t;
            }
            function pa(t, e) {
                return 0 != (t.flags & (e ? 16 : 32));
            }
            function fa(t, e = "") {
                const n = ke(),
                    r = Ae(),
                    s = t + 20,
                    i = r.firstCreatePass ? Js(r, s, 1, e, null) : r.data[s],
                    o = (n[s] = (function (t, e) {
                        return ce(t) ? t.createText(e) : t.createTextNode(e);
                    })(n[11], e));
                xs(r, n, o, i), Se(i, !1);
            }
            function ga(t) {
                return ma("", t, ""), ga;
            }
            function ma(t, e, n) {
                const r = ke(),
                    s = ao(r, t, e, n);
                return (
                    s !== Bs &&
                        (function (t, e, n) {
                            const r = de(e, t);
                            !(function (t, e, n) {
                                ce(t) ? t.setValue(e, n) : (e.textContent = n);
                            })(t[11], r, n);
                        })(r, Ge(), s),
                    ma
                );
            }
            function ya(t, e, n) {
                const r = ke();
                return (
                    io(r, De(), e) && ui(Ae(), Je(), r, t, e, r[11], n, !0), ya
                );
            }
            const va = void 0;
            var ba = [
                "en",
                [["a", "p"], ["AM", "PM"], va],
                [["AM", "PM"], va, va],
                [
                    ["S", "M", "T", "W", "T", "F", "S"],
                    ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                    [
                        "Sunday",
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday",
                        "Saturday",
                    ],
                    ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                ],
                va,
                [
                    [
                        "J",
                        "F",
                        "M",
                        "A",
                        "M",
                        "J",
                        "J",
                        "A",
                        "S",
                        "O",
                        "N",
                        "D",
                    ],
                    [
                        "Jan",
                        "Feb",
                        "Mar",
                        "Apr",
                        "May",
                        "Jun",
                        "Jul",
                        "Aug",
                        "Sep",
                        "Oct",
                        "Nov",
                        "Dec",
                    ],
                    [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July",
                        "August",
                        "September",
                        "October",
                        "November",
                        "December",
                    ],
                ],
                va,
                [
                    ["B", "A"],
                    ["BC", "AD"],
                    ["Before Christ", "Anno Domini"],
                ],
                0,
                [6, 0],
                ["M/d/yy", "MMM d, y", "MMMM d, y", "EEEE, MMMM d, y"],
                ["h:mm a", "h:mm:ss a", "h:mm:ss a z", "h:mm:ss a zzzz"],
                ["{1}, {0}", va, "{1} 'at' {0}", va],
                [
                    ".",
                    ",",
                    ";",
                    "%",
                    "+",
                    "-",
                    "E",
                    "\xd7",
                    "\u2030",
                    "\u221e",
                    "NaN",
                    ":",
                ],
                ["#,##0.###", "#,##0%", "\xa4#,##0.00", "#E0"],
                "USD",
                "$",
                "US Dollar",
                {},
                "ltr",
                function (t) {
                    let e = Math.floor(Math.abs(t)),
                        n = t.toString().replace(/^[^.]*\.?/, "").length;
                    return 1 === e && 0 === n ? 1 : 5;
                },
            ];
            let wa = {};
            function Ca(t) {
                return (
                    t in wa ||
                        (wa[t] =
                            kt.ng &&
                            kt.ng.common &&
                            kt.ng.common.locales &&
                            kt.ng.common.locales[t]),
                    wa[t]
                );
            }
            var xa = (function (t) {
                return (
                    (t[(t.LocaleId = 0)] = "LocaleId"),
                    (t[(t.DayPeriodsFormat = 1)] = "DayPeriodsFormat"),
                    (t[(t.DayPeriodsStandalone = 2)] = "DayPeriodsStandalone"),
                    (t[(t.DaysFormat = 3)] = "DaysFormat"),
                    (t[(t.DaysStandalone = 4)] = "DaysStandalone"),
                    (t[(t.MonthsFormat = 5)] = "MonthsFormat"),
                    (t[(t.MonthsStandalone = 6)] = "MonthsStandalone"),
                    (t[(t.Eras = 7)] = "Eras"),
                    (t[(t.FirstDayOfWeek = 8)] = "FirstDayOfWeek"),
                    (t[(t.WeekendRange = 9)] = "WeekendRange"),
                    (t[(t.DateFormat = 10)] = "DateFormat"),
                    (t[(t.TimeFormat = 11)] = "TimeFormat"),
                    (t[(t.DateTimeFormat = 12)] = "DateTimeFormat"),
                    (t[(t.NumberSymbols = 13)] = "NumberSymbols"),
                    (t[(t.NumberFormats = 14)] = "NumberFormats"),
                    (t[(t.CurrencyCode = 15)] = "CurrencyCode"),
                    (t[(t.CurrencySymbol = 16)] = "CurrencySymbol"),
                    (t[(t.CurrencyName = 17)] = "CurrencyName"),
                    (t[(t.Currencies = 18)] = "Currencies"),
                    (t[(t.Directionality = 19)] = "Directionality"),
                    (t[(t.PluralCase = 20)] = "PluralCase"),
                    (t[(t.ExtraData = 21)] = "ExtraData"),
                    t
                );
            })({});
            let _a = "en-US";
            function ka(t) {
                var e, n;
                (n = "Expected localeId to be defined"),
                    null == (e = t) &&
                        (function (t, e, n, r) {
                            throw new Error(
                                `ASSERTION ERROR: ${t} [Expected=> null != ${e} <=Actual]`
                            );
                        })(n, e),
                    "string" == typeof t &&
                        (_a = t.toLowerCase().replace(/_/g, "-"));
            }
            class Aa {}
            class Ea {
                resolveComponentFactory(t) {
                    throw (function (t) {
                        const e = Error(
                            `No component factory found for ${$(
                                t
                            )}. Did you add it to @NgModule.entryComponents?`
                        );
                        return (e.ngComponent = t), e;
                    })(t);
                }
            }
            let Ia = (() => {
                class t {}
                return (t.NULL = new Ea()), t;
            })();
            function Ta(...t) {}
            function Sa(t, e) {
                return new Ma(pe(t, e));
            }
            const Oa = function () {
                return Sa(Ie(), ke());
            };
            let Ma = (() => {
                class t {
                    constructor(t) {
                        this.nativeElement = t;
                    }
                }
                return (t.__NG_ELEMENT_ID__ = Oa), t;
            })();
            function Pa(t) {
                return t instanceof Ma ? t.nativeElement : t;
            }
            class Ra {}
            let Na = (() => {
                class t {}
                return (t.__NG_ELEMENT_ID__ = () => Da()), t;
            })();
            const Da = function () {
                const t = ke(),
                    e = ge(Ie().index, t);
                return (function (t) {
                    return t[11];
                })(Kt(e) ? e : t);
            };
            let Va = (() => {
                class t {}
                return (
                    (t.ɵprov = st({
                        token: t,
                        providedIn: "root",
                        factory: () => null,
                    })),
                    t
                );
            })();
            class Fa {
                constructor(t) {
                    (this.full = t),
                        (this.major = t.split(".")[0]),
                        (this.minor = t.split(".")[1]),
                        (this.patch = t.split(".").slice(2).join("."));
                }
            }
            const ja = new Fa("11.1.2");
            class za {
                constructor() {}
                supports(t) {
                    return no(t);
                }
                create(t) {
                    return new Ha(t);
                }
            }
            const Ba = (t, e) => e;
            class Ha {
                constructor(t) {
                    (this.length = 0),
                        (this._linkedRecords = null),
                        (this._unlinkedRecords = null),
                        (this._previousItHead = null),
                        (this._itHead = null),
                        (this._itTail = null),
                        (this._additionsHead = null),
                        (this._additionsTail = null),
                        (this._movesHead = null),
                        (this._movesTail = null),
                        (this._removalsHead = null),
                        (this._removalsTail = null),
                        (this._identityChangesHead = null),
                        (this._identityChangesTail = null),
                        (this._trackByFn = t || Ba);
                }
                forEachItem(t) {
                    let e;
                    for (e = this._itHead; null !== e; e = e._next) t(e);
                }
                forEachOperation(t) {
                    let e = this._itHead,
                        n = this._removalsHead,
                        r = 0,
                        s = null;
                    for (; e || n; ) {
                        const i =
                                !n || (e && e.currentIndex < Wa(n, r, s))
                                    ? e
                                    : n,
                            o = Wa(i, r, s),
                            a = i.currentIndex;
                        if (i === n) r--, (n = n._nextRemoved);
                        else if (((e = e._next), null == i.previousIndex)) r++;
                        else {
                            s || (s = []);
                            const t = o - r,
                                e = a - r;
                            if (t != e) {
                                for (let n = 0; n < t; n++) {
                                    const r = n < s.length ? s[n] : (s[n] = 0),
                                        i = r + n;
                                    e <= i && i < t && (s[n] = r + 1);
                                }
                                s[i.previousIndex] = e - t;
                            }
                        }
                        o !== a && t(i, o, a);
                    }
                }
                forEachPreviousItem(t) {
                    let e;
                    for (
                        e = this._previousItHead;
                        null !== e;
                        e = e._nextPrevious
                    )
                        t(e);
                }
                forEachAddedItem(t) {
                    let e;
                    for (e = this._additionsHead; null !== e; e = e._nextAdded)
                        t(e);
                }
                forEachMovedItem(t) {
                    let e;
                    for (e = this._movesHead; null !== e; e = e._nextMoved)
                        t(e);
                }
                forEachRemovedItem(t) {
                    let e;
                    for (e = this._removalsHead; null !== e; e = e._nextRemoved)
                        t(e);
                }
                forEachIdentityChange(t) {
                    let e;
                    for (
                        e = this._identityChangesHead;
                        null !== e;
                        e = e._nextIdentityChange
                    )
                        t(e);
                }
                diff(t) {
                    if ((null == t && (t = []), !no(t)))
                        throw new Error(
                            `Error trying to diff '${$(
                                t
                            )}'. Only arrays and iterables are allowed`
                        );
                    return this.check(t) ? this : null;
                }
                onDestroy() {}
                check(t) {
                    this._reset();
                    let e,
                        n,
                        r,
                        s = this._itHead,
                        i = !1;
                    if (Array.isArray(t)) {
                        this.length = t.length;
                        for (let e = 0; e < this.length; e++)
                            (n = t[e]),
                                (r = this._trackByFn(e, n)),
                                null !== s && Object.is(s.trackById, r)
                                    ? (i &&
                                          (s = this._verifyReinsertion(
                                              s,
                                              n,
                                              r,
                                              e
                                          )),
                                      Object.is(s.item, n) ||
                                          this._addIdentityChange(s, n))
                                    : ((s = this._mismatch(s, n, r, e)),
                                      (i = !0)),
                                (s = s._next);
                    } else
                        (e = 0),
                            (function (t, e) {
                                if (Array.isArray(t))
                                    for (let n = 0; n < t.length; n++) e(t[n]);
                                else {
                                    const n = t[to()]();
                                    let r;
                                    for (; !(r = n.next()).done; ) e(r.value);
                                }
                            })(t, (t) => {
                                (r = this._trackByFn(e, t)),
                                    null !== s && Object.is(s.trackById, r)
                                        ? (i &&
                                              (s = this._verifyReinsertion(
                                                  s,
                                                  t,
                                                  r,
                                                  e
                                              )),
                                          Object.is(s.item, t) ||
                                              this._addIdentityChange(s, t))
                                        : ((s = this._mismatch(s, t, r, e)),
                                          (i = !0)),
                                    (s = s._next),
                                    e++;
                            }),
                            (this.length = e);
                    return (
                        this._truncate(s), (this.collection = t), this.isDirty
                    );
                }
                get isDirty() {
                    return (
                        null !== this._additionsHead ||
                        null !== this._movesHead ||
                        null !== this._removalsHead ||
                        null !== this._identityChangesHead
                    );
                }
                _reset() {
                    if (this.isDirty) {
                        let t;
                        for (
                            t = this._previousItHead = this._itHead;
                            null !== t;
                            t = t._next
                        )
                            t._nextPrevious = t._next;
                        for (
                            t = this._additionsHead;
                            null !== t;
                            t = t._nextAdded
                        )
                            t.previousIndex = t.currentIndex;
                        for (
                            this._additionsHead = this._additionsTail = null,
                                t = this._movesHead;
                            null !== t;
                            t = t._nextMoved
                        )
                            t.previousIndex = t.currentIndex;
                        (this._movesHead = this._movesTail = null),
                            (this._removalsHead = this._removalsTail = null),
                            (this._identityChangesHead =
                                this._identityChangesTail =
                                    null);
                    }
                }
                _mismatch(t, e, n, r) {
                    let s;
                    return (
                        null === t
                            ? (s = this._itTail)
                            : ((s = t._prev), this._remove(t)),
                        null !==
                        (t =
                            null === this._linkedRecords
                                ? null
                                : this._linkedRecords.get(n, r))
                            ? (Object.is(t.item, e) ||
                                  this._addIdentityChange(t, e),
                              this._moveAfter(t, s, r))
                            : null !==
                              (t =
                                  null === this._unlinkedRecords
                                      ? null
                                      : this._unlinkedRecords.get(n, null))
                            ? (Object.is(t.item, e) ||
                                  this._addIdentityChange(t, e),
                              this._reinsertAfter(t, s, r))
                            : (t = this._addAfter(new La(e, n), s, r)),
                        t
                    );
                }
                _verifyReinsertion(t, e, n, r) {
                    let s =
                        null === this._unlinkedRecords
                            ? null
                            : this._unlinkedRecords.get(n, null);
                    return (
                        null !== s
                            ? (t = this._reinsertAfter(s, t._prev, r))
                            : t.currentIndex != r &&
                              ((t.currentIndex = r), this._addToMoves(t, r)),
                        t
                    );
                }
                _truncate(t) {
                    for (; null !== t; ) {
                        const e = t._next;
                        this._addToRemovals(this._unlink(t)), (t = e);
                    }
                    null !== this._unlinkedRecords &&
                        this._unlinkedRecords.clear(),
                        null !== this._additionsTail &&
                            (this._additionsTail._nextAdded = null),
                        null !== this._movesTail &&
                            (this._movesTail._nextMoved = null),
                        null !== this._itTail && (this._itTail._next = null),
                        null !== this._removalsTail &&
                            (this._removalsTail._nextRemoved = null),
                        null !== this._identityChangesTail &&
                            (this._identityChangesTail._nextIdentityChange =
                                null);
                }
                _reinsertAfter(t, e, n) {
                    null !== this._unlinkedRecords &&
                        this._unlinkedRecords.remove(t);
                    const r = t._prevRemoved,
                        s = t._nextRemoved;
                    return (
                        null === r
                            ? (this._removalsHead = s)
                            : (r._nextRemoved = s),
                        null === s
                            ? (this._removalsTail = r)
                            : (s._prevRemoved = r),
                        this._insertAfter(t, e, n),
                        this._addToMoves(t, n),
                        t
                    );
                }
                _moveAfter(t, e, n) {
                    return (
                        this._unlink(t),
                        this._insertAfter(t, e, n),
                        this._addToMoves(t, n),
                        t
                    );
                }
                _addAfter(t, e, n) {
                    return (
                        this._insertAfter(t, e, n),
                        (this._additionsTail =
                            null === this._additionsTail
                                ? (this._additionsHead = t)
                                : (this._additionsTail._nextAdded = t)),
                        t
                    );
                }
                _insertAfter(t, e, n) {
                    const r = null === e ? this._itHead : e._next;
                    return (
                        (t._next = r),
                        (t._prev = e),
                        null === r ? (this._itTail = t) : (r._prev = t),
                        null === e ? (this._itHead = t) : (e._next = t),
                        null === this._linkedRecords &&
                            (this._linkedRecords = new Ka()),
                        this._linkedRecords.put(t),
                        (t.currentIndex = n),
                        t
                    );
                }
                _remove(t) {
                    return this._addToRemovals(this._unlink(t));
                }
                _unlink(t) {
                    null !== this._linkedRecords &&
                        this._linkedRecords.remove(t);
                    const e = t._prev,
                        n = t._next;
                    return (
                        null === e ? (this._itHead = n) : (e._next = n),
                        null === n ? (this._itTail = e) : (n._prev = e),
                        t
                    );
                }
                _addToMoves(t, e) {
                    return (
                        t.previousIndex === e ||
                            (this._movesTail =
                                null === this._movesTail
                                    ? (this._movesHead = t)
                                    : (this._movesTail._nextMoved = t)),
                        t
                    );
                }
                _addToRemovals(t) {
                    return (
                        null === this._unlinkedRecords &&
                            (this._unlinkedRecords = new Ka()),
                        this._unlinkedRecords.put(t),
                        (t.currentIndex = null),
                        (t._nextRemoved = null),
                        null === this._removalsTail
                            ? ((this._removalsTail = this._removalsHead = t),
                              (t._prevRemoved = null))
                            : ((t._prevRemoved = this._removalsTail),
                              (this._removalsTail =
                                  this._removalsTail._nextRemoved =
                                      t)),
                        t
                    );
                }
                _addIdentityChange(t, e) {
                    return (
                        (t.item = e),
                        (this._identityChangesTail =
                            null === this._identityChangesTail
                                ? (this._identityChangesHead = t)
                                : (this._identityChangesTail._nextIdentityChange =
                                      t)),
                        t
                    );
                }
            }
            class La {
                constructor(t, e) {
                    (this.item = t),
                        (this.trackById = e),
                        (this.currentIndex = null),
                        (this.previousIndex = null),
                        (this._nextPrevious = null),
                        (this._prev = null),
                        (this._next = null),
                        (this._prevDup = null),
                        (this._nextDup = null),
                        (this._prevRemoved = null),
                        (this._nextRemoved = null),
                        (this._nextAdded = null),
                        (this._nextMoved = null),
                        (this._nextIdentityChange = null);
                }
            }
            class qa {
                constructor() {
                    (this._head = null), (this._tail = null);
                }
                add(t) {
                    null === this._head
                        ? ((this._head = this._tail = t),
                          (t._nextDup = null),
                          (t._prevDup = null))
                        : ((this._tail._nextDup = t),
                          (t._prevDup = this._tail),
                          (t._nextDup = null),
                          (this._tail = t));
                }
                get(t, e) {
                    let n;
                    for (n = this._head; null !== n; n = n._nextDup)
                        if (
                            (null === e || e <= n.currentIndex) &&
                            Object.is(n.trackById, t)
                        )
                            return n;
                    return null;
                }
                remove(t) {
                    const e = t._prevDup,
                        n = t._nextDup;
                    return (
                        null === e ? (this._head = n) : (e._nextDup = n),
                        null === n ? (this._tail = e) : (n._prevDup = e),
                        null === this._head
                    );
                }
            }
            class Ka {
                constructor() {
                    this.map = new Map();
                }
                put(t) {
                    const e = t.trackById;
                    let n = this.map.get(e);
                    n || ((n = new qa()), this.map.set(e, n)), n.add(t);
                }
                get(t, e) {
                    const n = this.map.get(t);
                    return n ? n.get(t, e) : null;
                }
                remove(t) {
                    const e = t.trackById;
                    return this.map.get(e).remove(t) && this.map.delete(e), t;
                }
                get isEmpty() {
                    return 0 === this.map.size;
                }
                clear() {
                    this.map.clear();
                }
            }
            function Wa(t, e, n) {
                const r = t.previousIndex;
                if (null === r) return r;
                let s = 0;
                return n && r < n.length && (s = n[r]), r + e + s;
            }
            class Ua {
                constructor() {}
                supports(t) {
                    return t instanceof Map || ro(t);
                }
                create() {
                    return new Za();
                }
            }
            class Za {
                constructor() {
                    (this._records = new Map()),
                        (this._mapHead = null),
                        (this._appendAfter = null),
                        (this._previousMapHead = null),
                        (this._changesHead = null),
                        (this._changesTail = null),
                        (this._additionsHead = null),
                        (this._additionsTail = null),
                        (this._removalsHead = null),
                        (this._removalsTail = null);
                }
                get isDirty() {
                    return (
                        null !== this._additionsHead ||
                        null !== this._changesHead ||
                        null !== this._removalsHead
                    );
                }
                forEachItem(t) {
                    let e;
                    for (e = this._mapHead; null !== e; e = e._next) t(e);
                }
                forEachPreviousItem(t) {
                    let e;
                    for (
                        e = this._previousMapHead;
                        null !== e;
                        e = e._nextPrevious
                    )
                        t(e);
                }
                forEachChangedItem(t) {
                    let e;
                    for (e = this._changesHead; null !== e; e = e._nextChanged)
                        t(e);
                }
                forEachAddedItem(t) {
                    let e;
                    for (e = this._additionsHead; null !== e; e = e._nextAdded)
                        t(e);
                }
                forEachRemovedItem(t) {
                    let e;
                    for (e = this._removalsHead; null !== e; e = e._nextRemoved)
                        t(e);
                }
                diff(t) {
                    if (t) {
                        if (!(t instanceof Map || ro(t)))
                            throw new Error(
                                `Error trying to diff '${$(
                                    t
                                )}'. Only maps and objects are allowed`
                            );
                    } else t = new Map();
                    return this.check(t) ? this : null;
                }
                onDestroy() {}
                check(t) {
                    this._reset();
                    let e = this._mapHead;
                    if (
                        ((this._appendAfter = null),
                        this._forEach(t, (t, n) => {
                            if (e && e.key === n)
                                this._maybeAddToChanges(e, t),
                                    (this._appendAfter = e),
                                    (e = e._next);
                            else {
                                const r = this._getOrCreateRecordForKey(n, t);
                                e = this._insertBeforeOrAppend(e, r);
                            }
                        }),
                        e)
                    ) {
                        e._prev && (e._prev._next = null),
                            (this._removalsHead = e);
                        for (let t = e; null !== t; t = t._nextRemoved)
                            t === this._mapHead && (this._mapHead = null),
                                this._records.delete(t.key),
                                (t._nextRemoved = t._next),
                                (t.previousValue = t.currentValue),
                                (t.currentValue = null),
                                (t._prev = null),
                                (t._next = null);
                    }
                    return (
                        this._changesTail &&
                            (this._changesTail._nextChanged = null),
                        this._additionsTail &&
                            (this._additionsTail._nextAdded = null),
                        this.isDirty
                    );
                }
                _insertBeforeOrAppend(t, e) {
                    if (t) {
                        const n = t._prev;
                        return (
                            (e._next = t),
                            (e._prev = n),
                            (t._prev = e),
                            n && (n._next = e),
                            t === this._mapHead && (this._mapHead = e),
                            (this._appendAfter = t),
                            t
                        );
                    }
                    return (
                        this._appendAfter
                            ? ((this._appendAfter._next = e),
                              (e._prev = this._appendAfter))
                            : (this._mapHead = e),
                        (this._appendAfter = e),
                        null
                    );
                }
                _getOrCreateRecordForKey(t, e) {
                    if (this._records.has(t)) {
                        const n = this._records.get(t);
                        this._maybeAddToChanges(n, e);
                        const r = n._prev,
                            s = n._next;
                        return (
                            r && (r._next = s),
                            s && (s._prev = r),
                            (n._next = null),
                            (n._prev = null),
                            n
                        );
                    }
                    const n = new Ya(t);
                    return (
                        this._records.set(t, n),
                        (n.currentValue = e),
                        this._addToAdditions(n),
                        n
                    );
                }
                _reset() {
                    if (this.isDirty) {
                        let t;
                        for (
                            this._previousMapHead = this._mapHead,
                                t = this._previousMapHead;
                            null !== t;
                            t = t._next
                        )
                            t._nextPrevious = t._next;
                        for (
                            t = this._changesHead;
                            null !== t;
                            t = t._nextChanged
                        )
                            t.previousValue = t.currentValue;
                        for (
                            t = this._additionsHead;
                            null != t;
                            t = t._nextAdded
                        )
                            t.previousValue = t.currentValue;
                        (this._changesHead = this._changesTail = null),
                            (this._additionsHead = this._additionsTail = null),
                            (this._removalsHead = null);
                    }
                }
                _maybeAddToChanges(t, e) {
                    Object.is(e, t.currentValue) ||
                        ((t.previousValue = t.currentValue),
                        (t.currentValue = e),
                        this._addToChanges(t));
                }
                _addToAdditions(t) {
                    null === this._additionsHead
                        ? (this._additionsHead = this._additionsTail = t)
                        : ((this._additionsTail._nextAdded = t),
                          (this._additionsTail = t));
                }
                _addToChanges(t) {
                    null === this._changesHead
                        ? (this._changesHead = this._changesTail = t)
                        : ((this._changesTail._nextChanged = t),
                          (this._changesTail = t));
                }
                _forEach(t, e) {
                    t instanceof Map
                        ? t.forEach(e)
                        : Object.keys(t).forEach((n) => e(t[n], n));
                }
            }
            class Ya {
                constructor(t) {
                    (this.key = t),
                        (this.previousValue = null),
                        (this.currentValue = null),
                        (this._nextPrevious = null),
                        (this._next = null),
                        (this._prev = null),
                        (this._nextAdded = null),
                        (this._nextRemoved = null),
                        (this._nextChanged = null);
                }
            }
            function Ga() {
                return new Xa([new za()]);
            }
            let Xa = (() => {
                class t {
                    constructor(t) {
                        this.factories = t;
                    }
                    static create(e, n) {
                        if (null != n) {
                            const t = n.factories.slice();
                            e = e.concat(t);
                        }
                        return new t(e);
                    }
                    static extend(e) {
                        return {
                            provide: t,
                            useFactory: (n) => t.create(e, n || Ga()),
                            deps: [[t, new ur(), new lr()]],
                        };
                    }
                    find(t) {
                        const e = this.factories.find((e) => e.supports(t));
                        if (null != e) return e;
                        throw new Error(
                            `Cannot find a differ supporting object '${t}' of type '${
                                ((n = t), n.name || typeof n)
                            }'`
                        );
                        var n;
                    }
                }
                return (
                    (t.ɵprov = st({
                        token: t,
                        providedIn: "root",
                        factory: Ga,
                    })),
                    t
                );
            })();
            function Ja() {
                return new Qa([new Ua()]);
            }
            let Qa = (() => {
                class t {
                    constructor(t) {
                        this.factories = t;
                    }
                    static create(e, n) {
                        if (n) {
                            const t = n.factories.slice();
                            e = e.concat(t);
                        }
                        return new t(e);
                    }
                    static extend(e) {
                        return {
                            provide: t,
                            useFactory: (n) => t.create(e, n || Ja()),
                            deps: [[t, new ur(), new lr()]],
                        };
                    }
                    find(t) {
                        const e = this.factories.find((e) => e.supports(t));
                        if (e) return e;
                        throw new Error(
                            `Cannot find a differ supporting object '${t}'`
                        );
                    }
                }
                return (
                    (t.ɵprov = st({
                        token: t,
                        providedIn: "root",
                        factory: Ja,
                    })),
                    t
                );
            })();
            function $a(t, e, n, r, s = !1) {
                for (; null !== n; ) {
                    const i = e[n.index];
                    if ((null !== i && r.push(he(i)), Wt(i)))
                        for (let t = 10; t < i.length; t++) {
                            const e = i[t],
                                n = e[1].firstChild;
                            null !== n && $a(e[1], e, n, r);
                        }
                    const o = n.type;
                    if (8 & o) $a(t, e, n.child, r);
                    else if (32 & o) {
                        const t = ss(n, e);
                        let s;
                        for (; (s = t()); ) r.push(s);
                    } else if (16 & o) {
                        const t = e[16],
                            s = t[6].projection[n.projection];
                        if (Array.isArray(s)) r.push(...s);
                        else {
                            const e = is(t);
                            $a(e[1], e, s, r, !0);
                        }
                    }
                    n = s ? n.projectionNext : n.next;
                }
                return r;
            }
            class tl {
                constructor(t, e) {
                    (this._lView = t),
                        (this._cdRefInjectingView = e),
                        (this._appRef = null),
                        (this._attachedToViewContainer = !1);
                }
                get rootNodes() {
                    const t = this._lView,
                        e = t[1];
                    return $a(e, t, e.firstChild, []);
                }
                get context() {
                    return this._lView[8];
                }
                get destroyed() {
                    return 256 == (256 & this._lView[2]);
                }
                destroy() {
                    if (this._appRef) this._appRef.detachView(this);
                    else if (this._attachedToViewContainer) {
                        const t = this._lView[3];
                        if (Wt(t)) {
                            const e = t[8],
                                n = e ? e.indexOf(this) : -1;
                            n > -1 && (ds(t, n), Bn(e, n));
                        }
                        this._attachedToViewContainer = !1;
                    }
                    ps(this._lView[1], this._lView);
                }
                onDestroy(t) {
                    li(this._lView[1], this._lView, null, t);
                }
                markForCheck() {
                    Ei(this._cdRefInjectingView || this._lView);
                }
                detach() {
                    this._lView[2] &= -129;
                }
                reattach() {
                    this._lView[2] |= 128;
                }
                detectChanges() {
                    Ii(this._lView[1], this._lView, this.context);
                }
                checkNoChanges() {
                    !(function (t, e, n) {
                        Re(!0);
                        try {
                            Ii(t, e, n);
                        } finally {
                            Re(!1);
                        }
                    })(this._lView[1], this._lView, this.context);
                }
                attachToViewContainerRef() {
                    if (this._appRef)
                        throw new Error(
                            "This view is already attached directly to the ApplicationRef!"
                        );
                    this._attachedToViewContainer = !0;
                }
                detachFromAppRef() {
                    var t;
                    (this._appRef = null),
                        Es(
                            this._lView[1],
                            (t = this._lView),
                            t[11],
                            2,
                            null,
                            null
                        );
                }
                attachToAppRef(t) {
                    if (this._attachedToViewContainer)
                        throw new Error(
                            "This view is already attached to a ViewContainer!"
                        );
                    this._appRef = t;
                }
            }
            class el extends tl {
                constructor(t) {
                    super(t), (this._view = t);
                }
                detectChanges() {
                    Ti(this._view);
                }
                checkNoChanges() {
                    !(function (t) {
                        Re(!0);
                        try {
                            Ti(t);
                        } finally {
                            Re(!1);
                        }
                    })(this._view);
                }
                get context() {
                    return null;
                }
            }
            const nl = function (t = !1) {
                return (function (t, e, n) {
                    if (!n && Zt(t)) {
                        const n = ge(t.index, e);
                        return new tl(n, n);
                    }
                    return 47 & t.type ? new tl(e[16], e) : null;
                })(Ie(), ke(), t);
            };
            let rl = (() => {
                class t {}
                return (
                    (t.__NG_ELEMENT_ID__ = nl),
                    (t.__ChangeDetectorRef__ = !0),
                    t
                );
            })();
            const sl = [new Ua()],
                il = new Xa([new za()]),
                ol = new Qa(sl),
                al = function () {
                    return hl(Ie(), ke());
                };
            let ll = (() => {
                class t {}
                return (t.__NG_ELEMENT_ID__ = al), t;
            })();
            const cl = ll,
                ul = class extends cl {
                    constructor(t, e, n) {
                        super(),
                            (this._declarationLView = t),
                            (this._declarationTContainer = e),
                            (this.elementRef = n);
                    }
                    createEmbeddedView(t) {
                        const e = this._declarationTContainer.tViews,
                            n = Xs(
                                this._declarationLView,
                                e,
                                t,
                                16,
                                null,
                                e.declTNode,
                                null,
                                null,
                                null,
                                null
                            );
                        n[17] =
                            this._declarationLView[
                                this._declarationTContainer.index
                            ];
                        const r = this._declarationLView[19];
                        return (
                            null !== r && (n[19] = r.createEmbeddedView(e)),
                            $s(e, n, t),
                            new tl(n)
                        );
                    }
                };
            function hl(t, e) {
                return 4 & t.type ? new ul(e, t, Sa(t, e)) : null;
            }
            class dl {}
            const pl = function () {
                return bl(Ie(), ke());
            };
            let fl = (() => {
                class t {}
                return (t.__NG_ELEMENT_ID__ = pl), t;
            })();
            const gl = fl,
                ml = class extends gl {
                    constructor(t, e, n) {
                        super(),
                            (this._lContainer = t),
                            (this._hostTNode = e),
                            (this._hostLView = n);
                    }
                    get element() {
                        return Sa(this._hostTNode, this._hostLView);
                    }
                    get injector() {
                        return new Mn(this._hostTNode, this._hostLView);
                    }
                    get parentInjector() {
                        const t = bn(this._hostTNode, this._hostLView);
                        if (un(t)) {
                            const e = dn(t, this._hostLView),
                                n = hn(t);
                            return new Mn(e[1].data[n + 8], e);
                        }
                        return new Mn(null, this._hostLView);
                    }
                    clear() {
                        for (; this.length > 0; ) this.remove(this.length - 1);
                    }
                    get(t) {
                        const e = yl(this._lContainer);
                        return (null !== e && e[t]) || null;
                    }
                    get length() {
                        return this._lContainer.length - 10;
                    }
                    createEmbeddedView(t, e, n) {
                        const r = t.createEmbeddedView(e || {});
                        return this.insert(r, n), r;
                    }
                    createComponent(t, e, n, r, s) {
                        const i = n || this.parentInjector;
                        if (!s && null == t.ngModule && i) {
                            const t = i.get(dl, null);
                            t && (s = t);
                        }
                        const o = t.create(i, r, void 0, s);
                        return this.insert(o.hostView, e), o;
                    }
                    insert(t, e) {
                        const n = t._lView,
                            r = n[1];
                        if (Wt(n[3])) {
                            const e = this.indexOf(t);
                            if (-1 !== e) this.detach(e);
                            else {
                                const e = n[3],
                                    r = new ml(e, e[6], e[3]);
                                r.detach(r.indexOf(t));
                            }
                        }
                        const s = this._adjustIndex(e),
                            i = this._lContainer;
                        !(function (t, e, n, r) {
                            const s = 10 + r,
                                i = n.length;
                            r > 0 && (n[s - 1][4] = e),
                                r < i - 10
                                    ? ((e[4] = n[s]), zn(n, 10 + r, e))
                                    : (n.push(e), (e[4] = null)),
                                (e[3] = n);
                            const o = e[17];
                            null !== o &&
                                n !== o &&
                                (function (t, e) {
                                    const n = t[9];
                                    e[16] !== e[3][3][16] && (t[2] = !0),
                                        null === n ? (t[9] = [e]) : n.push(e);
                                })(o, e);
                            const a = e[19];
                            null !== a && a.insertView(t), (e[2] |= 128);
                        })(r, n, i, s);
                        const o = ks(s, i),
                            a = n[11],
                            l = bs(a, i[7]);
                        return (
                            null !== l &&
                                (function (t, e, n, r, s, i) {
                                    (r[0] = s),
                                        (r[6] = e),
                                        Es(t, r, n, 1, s, i);
                                })(r, i[6], a, n, l, o),
                            t.attachToViewContainerRef(),
                            zn(vl(i), s, t),
                            t
                        );
                    }
                    move(t, e) {
                        return this.insert(t, e);
                    }
                    indexOf(t) {
                        const e = yl(this._lContainer);
                        return null !== e ? e.indexOf(t) : -1;
                    }
                    remove(t) {
                        const e = this._adjustIndex(t, -1),
                            n = ds(this._lContainer, e);
                        n && (Bn(vl(this._lContainer), e), ps(n[1], n));
                    }
                    detach(t) {
                        const e = this._adjustIndex(t, -1),
                            n = ds(this._lContainer, e);
                        return n && null != Bn(vl(this._lContainer), e)
                            ? new tl(n)
                            : null;
                    }
                    _adjustIndex(t, e = 0) {
                        return null == t ? this.length + e : t;
                    }
                };
            function yl(t) {
                return t[8];
            }
            function vl(t) {
                return t[8] || (t[8] = []);
            }
            function bl(t, e) {
                let n;
                const r = e[t.index];
                if (Wt(r)) n = r;
                else {
                    let s;
                    if (8 & t.type) s = he(r);
                    else {
                        const n = e[11];
                        s = n.createComment("");
                        const r = pe(t, e);
                        ms(
                            n,
                            bs(n, r),
                            s,
                            (function (t, e) {
                                return ce(t) ? t.nextSibling(e) : e.nextSibling;
                            })(n, r),
                            !1
                        );
                    }
                    (e[t.index] = n = Ci(r, e, s, t)), Ai(e, n);
                }
                return new ml(n, t, e);
            }
            const wl = {};
            class Cl extends Ia {
                constructor(t) {
                    super(), (this.ngModule = t);
                }
                resolveComponentFactory(t) {
                    const e = Lt(t);
                    return new kl(e, this.ngModule);
                }
            }
            function xl(t) {
                const e = [];
                for (let n in t)
                    t.hasOwnProperty(n) &&
                        e.push({ propName: t[n], templateName: n });
                return e;
            }
            const _l = new Nn("SCHEDULER_TOKEN", {
                providedIn: "root",
                factory: () => ts,
            });
            class kl extends Aa {
                constructor(t, e) {
                    super(),
                        (this.componentDef = t),
                        (this.ngModule = e),
                        (this.componentType = t.type),
                        (this.selector = t.selectors.map(zs).join(",")),
                        (this.ngContentSelectors = t.ngContentSelectors
                            ? t.ngContentSelectors
                            : []),
                        (this.isBoundToModule = !!e);
                }
                get inputs() {
                    return xl(this.componentDef.inputs);
                }
                get outputs() {
                    return xl(this.componentDef.outputs);
                }
                create(t, e, n, r) {
                    const s = (r = r || this.ngModule)
                            ? (function (t, e) {
                                  return {
                                      get: (n, r, s) => {
                                          const i = t.get(n, wl, s);
                                          return i !== wl || r === wl
                                              ? i
                                              : e.get(n, r, s);
                                      },
                                  };
                              })(t, r.injector)
                            : t,
                        i = s.get(Ra, ue),
                        o = s.get(Va, null),
                        a = i.createRenderer(null, this.componentDef),
                        l = this.componentDef.selectors[0][0] || "div",
                        c = n
                            ? (function (t, e, n) {
                                  if (ce(t))
                                      return t.selectRootElement(
                                          e,
                                          n === bt.ShadowDom
                                      );
                                  let r =
                                      "string" == typeof e
                                          ? t.querySelector(e)
                                          : e;
                                  return (r.textContent = ""), r;
                              })(a, n, this.componentDef.encapsulation)
                            : us(
                                  i.createRenderer(null, this.componentDef),
                                  l,
                                  (function (t) {
                                      const e = t.toLowerCase();
                                      return "svg" === e
                                          ? "http://www.w3.org/2000/svg"
                                          : "math" === e
                                          ? "http://www.w3.org/1998/MathML/"
                                          : null;
                                  })(l)
                              ),
                        u = this.componentDef.onPush ? 576 : 528,
                        h = {
                            components: [],
                            scheduler: ts,
                            clean: Oi,
                            playerHandler: null,
                            flags: 0,
                        },
                        d = ai(
                            0,
                            null,
                            null,
                            1,
                            0,
                            null,
                            null,
                            null,
                            null,
                            null
                        ),
                        p = Xs(null, d, h, u, null, null, i, a, o, s);
                    let f, g;
                    qe(p);
                    try {
                        const t = (function (t, e, n, r, s, i) {
                            const o = n[1];
                            n[20] = t;
                            const a = Js(o, 20, 2, "#host", null),
                                l = (a.mergedAttrs = e.hostAttrs);
                            null !== l &&
                                (Di(a, l, !0),
                                null !== t &&
                                    (on(s, t, l),
                                    null !== a.classes && Ss(s, t, a.classes),
                                    null !== a.styles && Ts(s, t, a.styles)));
                            const c = r.createRenderer(t, e),
                                u = Xs(
                                    n,
                                    oi(e),
                                    null,
                                    e.onPush ? 64 : 16,
                                    n[20],
                                    a,
                                    r,
                                    c,
                                    null,
                                    null
                                );
                            return (
                                o.firstCreatePass &&
                                    (wn(mn(a, n), o, e.type),
                                    fi(o, a),
                                    mi(a, n.length, 1)),
                                Ai(n, u),
                                (n[20] = u)
                            );
                        })(c, this.componentDef, p, i, a);
                        if (c)
                            if (n) on(a, c, ["ng-version", ja.full]);
                            else {
                                const { attrs: t, classes: e } = (function (t) {
                                    const e = [],
                                        n = [];
                                    let r = 1,
                                        s = 2;
                                    for (; r < t.length; ) {
                                        let i = t[r];
                                        if ("string" == typeof i)
                                            2 === s
                                                ? "" !== i && e.push(i, t[++r])
                                                : 8 === s && n.push(i);
                                        else {
                                            if (!Ds(s)) break;
                                            s = i;
                                        }
                                        r++;
                                    }
                                    return { attrs: e, classes: n };
                                })(this.componentDef.selectors[0]);
                                t && on(a, c, t),
                                    e && e.length > 0 && Ss(a, c, e.join(" "));
                            }
                        if (((g = fe(d, 20)), void 0 !== e)) {
                            const t = (g.projection = []);
                            for (
                                let n = 0;
                                n < this.ngContentSelectors.length;
                                n++
                            ) {
                                const r = e[n];
                                t.push(null != r ? Array.from(r) : null);
                            }
                        }
                        (f = (function (t, e, n, r, s) {
                            const i = n[1],
                                o = (function (t, e, n) {
                                    const r = Ie();
                                    t.firstCreatePass &&
                                        (n.providersResolver &&
                                            n.providersResolver(n),
                                        yi(t, r, e, Qs(t, e, 1, null), n));
                                    const s = Tn(e, t, r.directiveStart, r);
                                    $r(s, e);
                                    const i = pe(r, e);
                                    return i && $r(i, e), s;
                                })(i, n, e);
                            if (
                                (r.components.push(o),
                                (t[8] = o),
                                s && s.forEach((t) => t(o, e)),
                                e.contentQueries)
                            ) {
                                const t = Ie();
                                e.contentQueries(1, o, t.directiveStart);
                            }
                            const a = Ie();
                            return (
                                !i.firstCreatePass ||
                                    (null === e.hostBindings &&
                                        null === e.hostAttrs) ||
                                    (Xe(a.index),
                                    di(
                                        n[1],
                                        a,
                                        0,
                                        a.directiveStart,
                                        a.directiveEnd,
                                        e
                                    ),
                                    pi(e, o)),
                                o
                            );
                        })(t, this.componentDef, p, h, [Qi])),
                            $s(d, p, null);
                    } finally {
                        Ye();
                    }
                    return new Al(this.componentType, f, Sa(g, p), p, g);
                }
            }
            class Al extends class {} {
                constructor(t, e, n, r, s) {
                    super(),
                        (this.location = n),
                        (this._rootLView = r),
                        (this._tNode = s),
                        (this.instance = e),
                        (this.hostView = this.changeDetectorRef = new el(r)),
                        (this.componentType = t);
                }
                get injector() {
                    return new Mn(this._tNode, this._rootLView);
                }
                destroy() {
                    this.hostView.destroy();
                }
                onDestroy(t) {
                    this.hostView.onDestroy(t);
                }
            }
            const El = new Map();
            class Il extends dl {
                constructor(t, e) {
                    super(),
                        (this._parent = e),
                        (this._bootstrapComponents = []),
                        (this.injector = this),
                        (this.destroyCbs = []),
                        (this.componentFactoryResolver = new Cl(this));
                    const n = qt(t),
                        r = t[Mt] || null;
                    r && ka(r),
                        (this._bootstrapComponents = ns(n.bootstrap)),
                        (this._r3Injector = Ki(
                            t,
                            e,
                            [
                                { provide: dl, useValue: this },
                                {
                                    provide: Ia,
                                    useValue: this.componentFactoryResolver,
                                },
                            ],
                            $(t)
                        )),
                        this._r3Injector._resolveInjectorDefTypes(),
                        (this.instance = this.get(t));
                }
                get(t, e = Ji.THROW_IF_NOT_FOUND, n = pt.Default) {
                    return t === Ji || t === dl || t === Vi
                        ? this
                        : this._r3Injector.get(t, e, n);
                }
                destroy() {
                    const t = this._r3Injector;
                    !t.destroyed && t.destroy(),
                        this.destroyCbs.forEach((t) => t()),
                        (this.destroyCbs = null);
                }
                onDestroy(t) {
                    this.destroyCbs.push(t);
                }
            }
            class Tl extends class {} {
                constructor(t) {
                    super(),
                        (this.moduleType = t),
                        null !== qt(t) &&
                            (function (t) {
                                const e = new Set();
                                !(function t(n) {
                                    const r = qt(n, !0),
                                        s = r.id;
                                    null !== s &&
                                        ((function (t, e, n) {
                                            if (e && e !== n)
                                                throw new Error(
                                                    `Duplicate module registered for ${t} - ${$(
                                                        e
                                                    )} vs ${$(e.name)}`
                                                );
                                        })(s, El.get(s), n),
                                        El.set(s, n));
                                    const i = ns(r.imports);
                                    for (const o of i)
                                        e.has(o) || (e.add(o), t(o));
                                })(t);
                            })(t);
                }
                create(t) {
                    return new Il(this.moduleType, t);
                }
            }
            function Sl(t, e) {
                const n = t[e];
                return n === Bs ? void 0 : n;
            }
            function Ol(t, e, n, r, s, i) {
                const o = e + n;
                return io(t, o, s)
                    ? so(t, o + 1, i ? r.call(i, s) : r(s))
                    : Sl(t, o + 1);
            }
            function Ml(t, e) {
                const n = Ae();
                let r;
                const s = t + 20;
                n.firstCreatePass
                    ? ((r = (function (t, e) {
                          if (e)
                              for (let n = e.length - 1; n >= 0; n--) {
                                  const r = e[n];
                                  if (t === r.name) return r;
                              }
                          throw new Jt(
                              "302",
                              `The pipe '${t}' could not be found!`
                          );
                      })(e, n.pipeRegistry)),
                      (n.data[s] = r),
                      r.onDestroy &&
                          (n.destroyHooks || (n.destroyHooks = [])).push(
                              s,
                              r.onDestroy
                          ))
                    : (r = n.data[s]);
                const i = r.factory || (r.factory = Xt(r.type)),
                    o = gt(Ro);
                try {
                    const t = fn(!1),
                        e = i();
                    return (
                        fn(t),
                        (function (t, e, n, r) {
                            n >= t.data.length &&
                                ((t.data[n] = null), (t.blueprint[n] = null)),
                                (e[n] = r);
                        })(n, ke(), s, e),
                        e
                    );
                } finally {
                    gt(o);
                }
            }
            function Pl(t, e, n) {
                const r = t + 20,
                    s = ke(),
                    i = (function (t, e) {
                        return t[e];
                    })(s, r);
                return (function (t, e) {
                    return (
                        eo.isWrapped(e) &&
                            ((e = eo.unwrap(e)),
                            (t[xe.lFrame.bindingIndex] = Bs)),
                        e
                    );
                })(
                    s,
                    (function (t, e) {
                        return t[1].data[e].pure;
                    })(s, r)
                        ? Ol(s, Ne(), e, i.transform, n, i)
                        : i.transform(n)
                );
            }
            const Rl = class extends _ {
                constructor(t = !1) {
                    super(), (this.__isAsync = t);
                }
                emit(t) {
                    super.next(t);
                }
                subscribe(t, e, n) {
                    let r,
                        s = (t) => null,
                        i = () => null;
                    t && "object" == typeof t
                        ? ((r = this.__isAsync
                              ? (e) => {
                                    setTimeout(() => t.next(e));
                                }
                              : (e) => {
                                    t.next(e);
                                }),
                          t.error &&
                              (s = this.__isAsync
                                  ? (e) => {
                                        setTimeout(() => t.error(e));
                                    }
                                  : (e) => {
                                        t.error(e);
                                    }),
                          t.complete &&
                              (i = this.__isAsync
                                  ? () => {
                                        setTimeout(() => t.complete());
                                    }
                                  : () => {
                                        t.complete();
                                    }))
                        : ((r = this.__isAsync
                              ? (e) => {
                                    setTimeout(() => t(e));
                                }
                              : (e) => {
                                    t(e);
                                }),
                          e &&
                              (s = this.__isAsync
                                  ? (t) => {
                                        setTimeout(() => e(t));
                                    }
                                  : (t) => {
                                        e(t);
                                    }),
                          n &&
                              (i = this.__isAsync
                                  ? () => {
                                        setTimeout(() => n());
                                    }
                                  : () => {
                                        n();
                                    }));
                    const o = super.subscribe(r, s, i);
                    return t instanceof h && t.add(o), o;
                }
            };
            function Nl() {
                return this._results[to()]();
            }
            class Dl {
                constructor(t = !1) {
                    (this._emitDistinctChangesOnly = t),
                        (this.dirty = !0),
                        (this._results = []),
                        (this._changesDetected = !1),
                        (this._changes = null),
                        (this.length = 0),
                        (this.first = void 0),
                        (this.last = void 0);
                    const e = to(),
                        n = Dl.prototype;
                    n[e] || (n[e] = Nl);
                }
                get changes() {
                    return this._changes || (this._changes = new Rl());
                }
                get(t) {
                    return this._results[t];
                }
                map(t) {
                    return this._results.map(t);
                }
                filter(t) {
                    return this._results.filter(t);
                }
                find(t) {
                    return this._results.find(t);
                }
                reduce(t, e) {
                    return this._results.reduce(t, e);
                }
                forEach(t) {
                    this._results.forEach(t);
                }
                some(t) {
                    return this._results.some(t);
                }
                toArray() {
                    return this._results.slice();
                }
                toString() {
                    return this._results.toString();
                }
                reset(t, e) {
                    this.dirty = !1;
                    const n = Fn(t);
                    (this._changesDetected = !(function (t, e, n) {
                        if (t.length !== e.length) return !1;
                        for (let r = 0; r < t.length; r++) {
                            let s = t[r],
                                i = e[r];
                            if ((n && ((s = n(s)), (i = n(i))), i !== s))
                                return !1;
                        }
                        return !0;
                    })(this._results, n, e)) &&
                        ((this._results = n),
                        (this.length = n.length),
                        (this.last = n[this.length - 1]),
                        (this.first = n[0]));
                }
                notifyOnChanges() {
                    !this._changes ||
                        (!this._changesDetected &&
                            this._emitDistinctChangesOnly) ||
                        this._changes.emit(this);
                }
                setDirty() {
                    this.dirty = !0;
                }
                destroy() {
                    this.changes.complete(), this.changes.unsubscribe();
                }
            }
            class Vl {
                constructor(t) {
                    (this.queryList = t), (this.matches = null);
                }
                clone() {
                    return new Vl(this.queryList);
                }
                setDirty() {
                    this.queryList.setDirty();
                }
            }
            class Fl {
                constructor(t = []) {
                    this.queries = t;
                }
                createEmbeddedView(t) {
                    const e = t.queries;
                    if (null !== e) {
                        const n =
                                null !== t.contentQueries
                                    ? t.contentQueries[0]
                                    : e.length,
                            r = [];
                        for (let t = 0; t < n; t++) {
                            const n = e.getByIndex(t);
                            r.push(
                                this.queries[n.indexInDeclarationView].clone()
                            );
                        }
                        return new Fl(r);
                    }
                    return null;
                }
                insertView(t) {
                    this.dirtyQueriesWithMatches(t);
                }
                detachView(t) {
                    this.dirtyQueriesWithMatches(t);
                }
                dirtyQueriesWithMatches(t) {
                    for (let e = 0; e < this.queries.length; e++)
                        null !== Yl(t, e).matches && this.queries[e].setDirty();
                }
            }
            class jl {
                constructor(t, e, n = null) {
                    (this.predicate = t), (this.flags = e), (this.read = n);
                }
            }
            class zl {
                constructor(t = []) {
                    this.queries = t;
                }
                elementStart(t, e) {
                    for (let n = 0; n < this.queries.length; n++)
                        this.queries[n].elementStart(t, e);
                }
                elementEnd(t) {
                    for (let e = 0; e < this.queries.length; e++)
                        this.queries[e].elementEnd(t);
                }
                embeddedTView(t) {
                    let e = null;
                    for (let n = 0; n < this.length; n++) {
                        const r = null !== e ? e.length : 0,
                            s = this.getByIndex(n).embeddedTView(t, r);
                        s &&
                            ((s.indexInDeclarationView = n),
                            null !== e ? e.push(s) : (e = [s]));
                    }
                    return null !== e ? new zl(e) : null;
                }
                template(t, e) {
                    for (let n = 0; n < this.queries.length; n++)
                        this.queries[n].template(t, e);
                }
                getByIndex(t) {
                    return this.queries[t];
                }
                get length() {
                    return this.queries.length;
                }
                track(t) {
                    this.queries.push(t);
                }
            }
            class Bl {
                constructor(t, e = -1) {
                    (this.metadata = t),
                        (this.matches = null),
                        (this.indexInDeclarationView = -1),
                        (this.crossesNgTemplate = !1),
                        (this._appliesToNextNode = !0),
                        (this._declarationNodeIndex = e);
                }
                elementStart(t, e) {
                    this.isApplyingToNode(e) && this.matchTNode(t, e);
                }
                elementEnd(t) {
                    this._declarationNodeIndex === t.index &&
                        (this._appliesToNextNode = !1);
                }
                template(t, e) {
                    this.elementStart(t, e);
                }
                embeddedTView(t, e) {
                    return this.isApplyingToNode(t)
                        ? ((this.crossesNgTemplate = !0),
                          this.addMatch(-t.index, e),
                          new Bl(this.metadata))
                        : null;
                }
                isApplyingToNode(t) {
                    if (
                        this._appliesToNextNode &&
                        1 != (1 & this.metadata.flags)
                    ) {
                        const e = this._declarationNodeIndex;
                        let n = t.parent;
                        for (; null !== n && 8 & n.type && n.index !== e; )
                            n = n.parent;
                        return e === (null !== n ? n.index : -1);
                    }
                    return this._appliesToNextNode;
                }
                matchTNode(t, e) {
                    const n = this.metadata.predicate;
                    if (Array.isArray(n))
                        for (let r = 0; r < n.length; r++) {
                            const s = n[r];
                            this.matchTNodeWithReadOption(t, e, Hl(e, s)),
                                this.matchTNodeWithReadOption(
                                    t,
                                    e,
                                    In(e, t, s, !1, !1)
                                );
                        }
                    else
                        n === ll
                            ? 4 & e.type &&
                              this.matchTNodeWithReadOption(t, e, -1)
                            : this.matchTNodeWithReadOption(
                                  t,
                                  e,
                                  In(e, t, n, !1, !1)
                              );
                }
                matchTNodeWithReadOption(t, e, n) {
                    if (null !== n) {
                        const r = this.metadata.read;
                        if (null !== r)
                            if (
                                r === Ma ||
                                r === fl ||
                                (r === ll && 4 & e.type)
                            )
                                this.addMatch(e.index, -2);
                            else {
                                const n = In(e, t, r, !1, !1);
                                null !== n && this.addMatch(e.index, n);
                            }
                        else this.addMatch(e.index, n);
                    }
                }
                addMatch(t, e) {
                    null === this.matches
                        ? (this.matches = [t, e])
                        : this.matches.push(t, e);
                }
            }
            function Hl(t, e) {
                const n = t.localNames;
                if (null !== n)
                    for (let r = 0; r < n.length; r += 2)
                        if (n[r] === e) return n[r + 1];
                return null;
            }
            function Ll(t, e, n, r) {
                return -1 === n
                    ? (function (t, e) {
                          return 11 & t.type
                              ? Sa(t, e)
                              : 4 & t.type
                              ? hl(t, e)
                              : null;
                      })(e, t)
                    : -2 === n
                    ? (function (t, e, n) {
                          return n === Ma
                              ? Sa(e, t)
                              : n === ll
                              ? hl(e, t)
                              : n === fl
                              ? bl(e, t)
                              : void 0;
                      })(t, e, r)
                    : Tn(t, t[1], n, e);
            }
            function ql(t, e, n, r) {
                const s = e[19].queries[r];
                if (null === s.matches) {
                    const r = t.data,
                        i = n.matches,
                        o = [];
                    for (let t = 0; t < i.length; t += 2) {
                        const s = i[t];
                        o.push(
                            s < 0
                                ? null
                                : Ll(e, r[s], i[t + 1], n.metadata.read)
                        );
                    }
                    s.matches = o;
                }
                return s.matches;
            }
            function Kl(t, e, n, r) {
                const s = t.queries.getByIndex(n),
                    i = s.matches;
                if (null !== i) {
                    const o = ql(t, e, s, n);
                    for (let t = 0; t < i.length; t += 2) {
                        const n = i[t];
                        if (n > 0) r.push(o[t / 2]);
                        else {
                            const s = i[t + 1],
                                o = e[-n];
                            for (let t = 10; t < o.length; t++) {
                                const e = o[t];
                                e[17] === e[3] && Kl(e[1], e, s, r);
                            }
                            if (null !== o[9]) {
                                const t = o[9];
                                for (let e = 0; e < t.length; e++) {
                                    const n = t[e];
                                    Kl(n[1], n, s, r);
                                }
                            }
                        }
                    }
                }
                return r;
            }
            function Wl(t) {
                const e = ke(),
                    n = Ae(),
                    r = ze();
                Be(r + 1);
                const s = Yl(n, r);
                if (t.dirty && ye(e) === (2 == (2 & s.metadata.flags))) {
                    if (null === s.matches) t.reset([]);
                    else {
                        const i = s.crossesNgTemplate
                            ? Kl(n, e, r, [])
                            : ql(n, e, s, r);
                        t.reset(i, Pa), t.notifyOnChanges();
                    }
                    return !0;
                }
                return !1;
            }
            function Ul(t, e, n) {
                const r = Ae();
                r.firstCreatePass &&
                    ((function (t, e, n) {
                        null === t.queries && (t.queries = new zl()),
                            t.queries.track(new Bl(e, -1));
                    })(r, new jl(t, e, n)),
                    2 == (2 & e) && (r.staticViewQueries = !0)),
                    (function (t, e, n) {
                        const r = new Dl(4 == (4 & n));
                        li(t, e, r, r.destroy),
                            null === e[19] && (e[19] = new Fl()),
                            e[19].queries.push(new Vl(r));
                    })(r, ke(), e);
            }
            function Zl() {
                return (t = ke()), (e = ze()), t[19].queries[e].queryList;
                var t, e;
            }
            function Yl(t, e) {
                return t.queries.getByIndex(e);
            }
            const Gl = new Nn("Application Initializer");
            let Xl = (() => {
                class t {
                    constructor(t) {
                        (this.appInits = t),
                            (this.resolve = Ta),
                            (this.reject = Ta),
                            (this.initialized = !1),
                            (this.done = !1),
                            (this.donePromise = new Promise((t, e) => {
                                (this.resolve = t), (this.reject = e);
                            }));
                    }
                    runInitializers() {
                        if (this.initialized) return;
                        const t = [],
                            e = () => {
                                (this.done = !0), this.resolve();
                            };
                        if (this.appInits)
                            for (let n = 0; n < this.appInits.length; n++) {
                                const e = this.appInits[n]();
                                Lo(e) && t.push(e);
                            }
                        Promise.all(t)
                            .then(() => {
                                e();
                            })
                            .catch((t) => {
                                this.reject(t);
                            }),
                            0 === t.length && e(),
                            (this.initialized = !0);
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(Gl, 8));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            const Jl = new Nn("AppId"),
                Ql = {
                    provide: Jl,
                    useFactory: function () {
                        return `${$l()}${$l()}${$l()}`;
                    },
                    deps: [],
                };
            function $l() {
                return String.fromCharCode(97 + Math.floor(25 * Math.random()));
            }
            const tc = new Nn("Platform Initializer"),
                ec = new Nn("Platform ID"),
                nc = new Nn("appBootstrapListener");
            let rc = (() => {
                class t {
                    log(t) {
                        console.log(t);
                    }
                    warn(t) {
                        console.warn(t);
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)();
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            const sc = new Nn("LocaleId"),
                ic = new Nn("DefaultCurrencyCode");
            class oc {
                constructor(t, e) {
                    (this.ngModuleFactory = t), (this.componentFactories = e);
                }
            }
            const ac = function (t) {
                    return new Tl(t);
                },
                lc = ac,
                cc = function (t) {
                    return Promise.resolve(ac(t));
                },
                uc = function (t) {
                    const e = ac(t),
                        n = ns(qt(t).declarations).reduce((t, e) => {
                            const n = Lt(e);
                            return n && t.push(new kl(n)), t;
                        }, []);
                    return new oc(e, n);
                },
                hc = uc,
                dc = function (t) {
                    return Promise.resolve(uc(t));
                };
            let pc = (() => {
                class t {
                    constructor() {
                        (this.compileModuleSync = lc),
                            (this.compileModuleAsync = cc),
                            (this.compileModuleAndAllComponentsSync = hc),
                            (this.compileModuleAndAllComponentsAsync = dc);
                    }
                    clearCache() {}
                    clearCacheFor(t) {}
                    getModuleId(t) {}
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)();
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            const fc = (() => Promise.resolve(0))();
            function gc(t) {
                "undefined" == typeof Zone
                    ? fc.then(() => {
                          t && t.apply(null, null);
                      })
                    : Zone.current.scheduleMicroTask("scheduleMicrotask", t);
            }
            class mc {
                constructor({
                    enableLongStackTrace: t = !1,
                    shouldCoalesceEventChangeDetection: e = !1,
                    shouldCoalesceRunChangeDetection: n = !1,
                }) {
                    if (
                        ((this.hasPendingMacrotasks = !1),
                        (this.hasPendingMicrotasks = !1),
                        (this.isStable = !0),
                        (this.onUnstable = new Rl(!1)),
                        (this.onMicrotaskEmpty = new Rl(!1)),
                        (this.onStable = new Rl(!1)),
                        (this.onError = new Rl(!1)),
                        "undefined" == typeof Zone)
                    )
                        throw new Error(
                            "In this configuration Angular requires Zone.js"
                        );
                    Zone.assertZonePatched(),
                        (this._nesting = 0),
                        (this._outer = this._inner = Zone.current),
                        Zone.TaskTrackingZoneSpec &&
                            (this._inner = this._inner.fork(
                                new Zone.TaskTrackingZoneSpec()
                            )),
                        t &&
                            Zone.longStackTraceZoneSpec &&
                            (this._inner = this._inner.fork(
                                Zone.longStackTraceZoneSpec
                            )),
                        (this.shouldCoalesceEventChangeDetection = !n && e),
                        (this.shouldCoalesceRunChangeDetection = n),
                        (this.lastRequestAnimationFrameId = -1),
                        (this.nativeRequestAnimationFrame = (function () {
                            let t = kt.requestAnimationFrame,
                                e = kt.cancelAnimationFrame;
                            if ("undefined" != typeof Zone && t && e) {
                                const n =
                                    t[Zone.__symbol__("OriginalDelegate")];
                                n && (t = n);
                                const r =
                                    e[Zone.__symbol__("OriginalDelegate")];
                                r && (e = r);
                            }
                            return {
                                nativeRequestAnimationFrame: t,
                                nativeCancelAnimationFrame: e,
                            };
                        })().nativeRequestAnimationFrame),
                        (function (t) {
                            const e = () => {
                                !(function (t) {
                                    -1 === t.lastRequestAnimationFrameId &&
                                        ((t.lastRequestAnimationFrameId =
                                            t.nativeRequestAnimationFrame.call(
                                                kt,
                                                () => {
                                                    t.fakeTopEventTask ||
                                                        (t.fakeTopEventTask =
                                                            Zone.root.scheduleEventTask(
                                                                "fakeTopEventTask",
                                                                () => {
                                                                    (t.lastRequestAnimationFrameId =
                                                                        -1),
                                                                        bc(t),
                                                                        vc(t);
                                                                },
                                                                void 0,
                                                                () => {},
                                                                () => {}
                                                            )),
                                                        t.fakeTopEventTask.invoke();
                                                }
                                            )),
                                        bc(t));
                                })(t);
                            };
                            t._inner = t._inner.fork({
                                name: "angular",
                                properties: { isAngularZone: !0 },
                                onInvokeTask: (n, r, s, i, o, a) => {
                                    try {
                                        return wc(t), n.invokeTask(s, i, o, a);
                                    } finally {
                                        ((t.shouldCoalesceEventChangeDetection &&
                                            "eventTask" === i.type) ||
                                            t.shouldCoalesceRunChangeDetection) &&
                                            e(),
                                            Cc(t);
                                    }
                                },
                                onInvoke: (n, r, s, i, o, a, l) => {
                                    try {
                                        return wc(t), n.invoke(s, i, o, a, l);
                                    } finally {
                                        t.shouldCoalesceRunChangeDetection &&
                                            e(),
                                            Cc(t);
                                    }
                                },
                                onHasTask: (e, n, r, s) => {
                                    e.hasTask(r, s),
                                        n === r &&
                                            ("microTask" == s.change
                                                ? ((t._hasPendingMicrotasks =
                                                      s.microTask),
                                                  bc(t),
                                                  vc(t))
                                                : "macroTask" == s.change &&
                                                  (t.hasPendingMacrotasks =
                                                      s.macroTask));
                                },
                                onHandleError: (e, n, r, s) => (
                                    e.handleError(r, s),
                                    t.runOutsideAngular(() =>
                                        t.onError.emit(s)
                                    ),
                                    !1
                                ),
                            });
                        })(this);
                }
                static isInAngularZone() {
                    return !0 === Zone.current.get("isAngularZone");
                }
                static assertInAngularZone() {
                    if (!mc.isInAngularZone())
                        throw new Error(
                            "Expected to be in Angular Zone, but it is not!"
                        );
                }
                static assertNotInAngularZone() {
                    if (mc.isInAngularZone())
                        throw new Error(
                            "Expected to not be in Angular Zone, but it is!"
                        );
                }
                run(t, e, n) {
                    return this._inner.run(t, e, n);
                }
                runTask(t, e, n, r) {
                    const s = this._inner,
                        i = s.scheduleEventTask(
                            "NgZoneEvent: " + r,
                            t,
                            yc,
                            Ta,
                            Ta
                        );
                    try {
                        return s.runTask(i, e, n);
                    } finally {
                        s.cancelTask(i);
                    }
                }
                runGuarded(t, e, n) {
                    return this._inner.runGuarded(t, e, n);
                }
                runOutsideAngular(t) {
                    return this._outer.run(t);
                }
            }
            const yc = {};
            function vc(t) {
                if (0 == t._nesting && !t.hasPendingMicrotasks && !t.isStable)
                    try {
                        t._nesting++, t.onMicrotaskEmpty.emit(null);
                    } finally {
                        if ((t._nesting--, !t.hasPendingMicrotasks))
                            try {
                                t.runOutsideAngular(() =>
                                    t.onStable.emit(null)
                                );
                            } finally {
                                t.isStable = !0;
                            }
                    }
            }
            function bc(t) {
                t.hasPendingMicrotasks = !!(
                    t._hasPendingMicrotasks ||
                    ((t.shouldCoalesceEventChangeDetection ||
                        t.shouldCoalesceRunChangeDetection) &&
                        -1 !== t.lastRequestAnimationFrameId)
                );
            }
            function wc(t) {
                t._nesting++,
                    t.isStable && ((t.isStable = !1), t.onUnstable.emit(null));
            }
            function Cc(t) {
                t._nesting--, vc(t);
            }
            class xc {
                constructor() {
                    (this.hasPendingMicrotasks = !1),
                        (this.hasPendingMacrotasks = !1),
                        (this.isStable = !0),
                        (this.onUnstable = new Rl()),
                        (this.onMicrotaskEmpty = new Rl()),
                        (this.onStable = new Rl()),
                        (this.onError = new Rl());
                }
                run(t, e, n) {
                    return t.apply(e, n);
                }
                runGuarded(t, e, n) {
                    return t.apply(e, n);
                }
                runOutsideAngular(t) {
                    return t();
                }
                runTask(t, e, n, r) {
                    return t.apply(e, n);
                }
            }
            let _c = (() => {
                    class t {
                        constructor(t) {
                            (this._ngZone = t),
                                (this._pendingCount = 0),
                                (this._isZoneStable = !0),
                                (this._didWork = !1),
                                (this._callbacks = []),
                                (this.taskTrackingZone = null),
                                this._watchAngularEvents(),
                                t.run(() => {
                                    this.taskTrackingZone =
                                        "undefined" == typeof Zone
                                            ? null
                                            : Zone.current.get(
                                                  "TaskTrackingZone"
                                              );
                                });
                        }
                        _watchAngularEvents() {
                            this._ngZone.onUnstable.subscribe({
                                next: () => {
                                    (this._didWork = !0),
                                        (this._isZoneStable = !1);
                                },
                            }),
                                this._ngZone.runOutsideAngular(() => {
                                    this._ngZone.onStable.subscribe({
                                        next: () => {
                                            mc.assertNotInAngularZone(),
                                                gc(() => {
                                                    (this._isZoneStable = !0),
                                                        this._runCallbacksIfReady();
                                                });
                                        },
                                    });
                                });
                        }
                        increasePendingRequestCount() {
                            return (
                                (this._pendingCount += 1),
                                (this._didWork = !0),
                                this._pendingCount
                            );
                        }
                        decreasePendingRequestCount() {
                            if (
                                ((this._pendingCount -= 1),
                                this._pendingCount < 0)
                            )
                                throw new Error(
                                    "pending async requests below zero"
                                );
                            return (
                                this._runCallbacksIfReady(), this._pendingCount
                            );
                        }
                        isStable() {
                            return (
                                this._isZoneStable &&
                                0 === this._pendingCount &&
                                !this._ngZone.hasPendingMacrotasks
                            );
                        }
                        _runCallbacksIfReady() {
                            if (this.isStable())
                                gc(() => {
                                    for (; 0 !== this._callbacks.length; ) {
                                        let t = this._callbacks.pop();
                                        clearTimeout(t.timeoutId),
                                            t.doneCb(this._didWork);
                                    }
                                    this._didWork = !1;
                                });
                            else {
                                let t = this.getPendingTasks();
                                (this._callbacks = this._callbacks.filter(
                                    (e) =>
                                        !e.updateCb ||
                                        !e.updateCb(t) ||
                                        (clearTimeout(e.timeoutId), !1)
                                )),
                                    (this._didWork = !0);
                            }
                        }
                        getPendingTasks() {
                            return this.taskTrackingZone
                                ? this.taskTrackingZone.macroTasks.map((t) => ({
                                      source: t.source,
                                      creationLocation: t.creationLocation,
                                      data: t.data,
                                  }))
                                : [];
                        }
                        addCallback(t, e, n) {
                            let r = -1;
                            e &&
                                e > 0 &&
                                (r = setTimeout(() => {
                                    (this._callbacks = this._callbacks.filter(
                                        (t) => t.timeoutId !== r
                                    )),
                                        t(
                                            this._didWork,
                                            this.getPendingTasks()
                                        );
                                }, e)),
                                this._callbacks.push({
                                    doneCb: t,
                                    timeoutId: r,
                                    updateCb: n,
                                });
                        }
                        whenStable(t, e, n) {
                            if (n && !this.taskTrackingZone)
                                throw new Error(
                                    'Task tracking zone is required when passing an update callback to whenStable(). Is "zone.js/dist/task-tracking.js" loaded?'
                                );
                            this.addCallback(t, e, n),
                                this._runCallbacksIfReady();
                        }
                        getPendingRequestCount() {
                            return this._pendingCount;
                        }
                        findProviders(t, e, n) {
                            return [];
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(mc));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                kc = (() => {
                    class t {
                        constructor() {
                            (this._applications = new Map()),
                                Ic.addToWindow(this);
                        }
                        registerApplication(t, e) {
                            this._applications.set(t, e);
                        }
                        unregisterApplication(t) {
                            this._applications.delete(t);
                        }
                        unregisterAllApplications() {
                            this._applications.clear();
                        }
                        getTestability(t) {
                            return this._applications.get(t) || null;
                        }
                        getAllTestabilities() {
                            return Array.from(this._applications.values());
                        }
                        getAllRootElements() {
                            return Array.from(this._applications.keys());
                        }
                        findTestabilityInTree(t, e = !0) {
                            return Ic.findTestabilityInTree(this, t, e);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })();
            class Ac {
                addToWindow(t) {}
                findTestabilityInTree(t, e, n) {
                    return null;
                }
            }
            let Ec,
                Ic = new Ac(),
                Tc = !0,
                Sc = !1;
            function Oc() {
                return (Sc = !0), Tc;
            }
            const Mc = new Nn("AllowMultipleToken");
            function Pc(t, e, n = []) {
                const r = `Platform: ${e}`,
                    s = new Nn(r);
                return (e = []) => {
                    let i = Rc();
                    if (!i || i.injector.get(Mc, !1))
                        if (t)
                            t(n.concat(e).concat({ provide: s, useValue: !0 }));
                        else {
                            const t = n
                                .concat(e)
                                .concat(
                                    { provide: s, useValue: !0 },
                                    { provide: ji, useValue: "platform" }
                                );
                            !(function (t) {
                                if (
                                    Ec &&
                                    !Ec.destroyed &&
                                    !Ec.injector.get(Mc, !1)
                                )
                                    throw new Error(
                                        "There can be only one platform. Destroy the previous one to create a new one."
                                    );
                                Ec = t.get(Nc);
                                const e = t.get(tc, null);
                                e && e.forEach((t) => t());
                            })(Ji.create({ providers: t, name: r }));
                        }
                    return (function (t) {
                        const e = Rc();
                        if (!e) throw new Error("No platform exists!");
                        if (!e.injector.get(t, null))
                            throw new Error(
                                "A platform with a different configuration has been created. Please destroy it first."
                            );
                        return e;
                    })(s);
                };
            }
            function Rc() {
                return Ec && !Ec.destroyed ? Ec : null;
            }
            let Nc = (() => {
                class t {
                    constructor(t) {
                        (this._injector = t),
                            (this._modules = []),
                            (this._destroyListeners = []),
                            (this._destroyed = !1);
                    }
                    bootstrapModuleFactory(t, e) {
                        const n = (function (t, e) {
                                let n;
                                return (
                                    (n =
                                        "noop" === t
                                            ? new xc()
                                            : ("zone.js" === t ? void 0 : t) ||
                                              new mc({
                                                  enableLongStackTrace: Oc(),
                                                  shouldCoalesceEventChangeDetection:
                                                      !!(null == e
                                                          ? void 0
                                                          : e.ngZoneEventCoalescing),
                                                  shouldCoalesceRunChangeDetection:
                                                      !!(null == e
                                                          ? void 0
                                                          : e.ngZoneRunCoalescing),
                                              })),
                                    n
                                );
                            })(e ? e.ngZone : void 0, {
                                ngZoneEventCoalescing:
                                    (e && e.ngZoneEventCoalescing) || !1,
                                ngZoneRunCoalescing:
                                    (e && e.ngZoneRunCoalescing) || !1,
                            }),
                            r = [{ provide: mc, useValue: n }];
                        return n.run(() => {
                            const e = Ji.create({
                                    providers: r,
                                    parent: this.injector,
                                    name: t.moduleType.name,
                                }),
                                s = t.create(e),
                                i = s.injector.get(Qr, null);
                            if (!i)
                                throw new Error(
                                    "No ErrorHandler. Is platform module (BrowserModule) included?"
                                );
                            return (
                                n.runOutsideAngular(() => {
                                    const t = n.onError.subscribe({
                                        next: (t) => {
                                            i.handleError(t);
                                        },
                                    });
                                    s.onDestroy(() => {
                                        Fc(this._modules, s), t.unsubscribe();
                                    });
                                }),
                                (function (t, e, n) {
                                    try {
                                        const r = n();
                                        return Lo(r)
                                            ? r.catch((n) => {
                                                  throw (
                                                      (e.runOutsideAngular(() =>
                                                          t.handleError(n)
                                                      ),
                                                      n)
                                                  );
                                              })
                                            : r;
                                    } catch (r) {
                                        throw (
                                            (e.runOutsideAngular(() =>
                                                t.handleError(r)
                                            ),
                                            r)
                                        );
                                    }
                                })(i, n, () => {
                                    const t = s.injector.get(Xl);
                                    return (
                                        t.runInitializers(),
                                        t.donePromise.then(
                                            () => (
                                                ka(
                                                    s.injector.get(
                                                        sc,
                                                        "en-US"
                                                    ) || "en-US"
                                                ),
                                                this._moduleDoBootstrap(s),
                                                s
                                            )
                                        )
                                    );
                                })
                            );
                        });
                    }
                    bootstrapModule(t, e = []) {
                        const n = Dc({}, e);
                        return (function (t, e, n) {
                            const r = new Tl(n);
                            return Promise.resolve(r);
                        })(0, 0, t).then((t) =>
                            this.bootstrapModuleFactory(t, n)
                        );
                    }
                    _moduleDoBootstrap(t) {
                        const e = t.injector.get(Vc);
                        if (t._bootstrapComponents.length > 0)
                            t._bootstrapComponents.forEach((t) =>
                                e.bootstrap(t)
                            );
                        else {
                            if (!t.instance.ngDoBootstrap)
                                throw new Error(
                                    `The module ${$(
                                        t.instance.constructor
                                    )} was bootstrapped, but it does not declare "@NgModule.bootstrap" components nor a "ngDoBootstrap" method. Please define one of these.`
                                );
                            t.instance.ngDoBootstrap(e);
                        }
                        this._modules.push(t);
                    }
                    onDestroy(t) {
                        this._destroyListeners.push(t);
                    }
                    get injector() {
                        return this._injector;
                    }
                    destroy() {
                        if (this._destroyed)
                            throw new Error(
                                "The platform has already been destroyed!"
                            );
                        this._modules.slice().forEach((t) => t.destroy()),
                            this._destroyListeners.forEach((t) => t()),
                            (this._destroyed = !0);
                    }
                    get destroyed() {
                        return this._destroyed;
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(Ji));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            function Dc(t, e) {
                return Array.isArray(e)
                    ? e.reduce(Dc, t)
                    : Object.assign(Object.assign({}, t), e);
            }
            let Vc = (() => {
                class t {
                    constructor(t, e, n, r, s, i) {
                        (this._zone = t),
                            (this._console = e),
                            (this._injector = n),
                            (this._exceptionHandler = r),
                            (this._componentFactoryResolver = s),
                            (this._initStatus = i),
                            (this._bootstrapListeners = []),
                            (this._views = []),
                            (this._runningTick = !1),
                            (this._stable = !0),
                            (this.componentTypes = []),
                            (this.components = []),
                            (this._onMicrotaskEmptySubscription =
                                this._zone.onMicrotaskEmpty.subscribe({
                                    next: () => {
                                        this._zone.run(() => {
                                            this.tick();
                                        });
                                    },
                                }));
                        const o = new v((t) => {
                                (this._stable =
                                    this._zone.isStable &&
                                    !this._zone.hasPendingMacrotasks &&
                                    !this._zone.hasPendingMicrotasks),
                                    this._zone.runOutsideAngular(() => {
                                        t.next(this._stable), t.complete();
                                    });
                            }),
                            a = new v((t) => {
                                let e;
                                this._zone.runOutsideAngular(() => {
                                    e = this._zone.onStable.subscribe(() => {
                                        mc.assertNotInAngularZone(),
                                            gc(() => {
                                                this._stable ||
                                                    this._zone
                                                        .hasPendingMacrotasks ||
                                                    this._zone
                                                        .hasPendingMicrotasks ||
                                                    ((this._stable = !0),
                                                    t.next(!0));
                                            });
                                    });
                                });
                                const n = this._zone.onUnstable.subscribe(
                                    () => {
                                        mc.assertInAngularZone(),
                                            this._stable &&
                                                ((this._stable = !1),
                                                this._zone.runOutsideAngular(
                                                    () => {
                                                        t.next(!1);
                                                    }
                                                ));
                                    }
                                );
                                return () => {
                                    e.unsubscribe(), n.unsubscribe();
                                };
                            });
                        this.isStable = K(
                            o,
                            a.pipe((t) => {
                                return W()(
                                    ((e = J),
                                    function (t) {
                                        let n;
                                        n =
                                            "function" == typeof e
                                                ? e
                                                : function () {
                                                      return e;
                                                  };
                                        const r = Object.create(t, G);
                                        return (
                                            (r.source = t),
                                            (r.subjectFactory = n),
                                            r
                                        );
                                    })(t)
                                );
                                var e;
                            })
                        );
                    }
                    bootstrap(t, e) {
                        if (!this._initStatus.done)
                            throw new Error(
                                "Cannot bootstrap as there are still asynchronous initializers running. Bootstrap components in the `ngDoBootstrap` method of the root module."
                            );
                        let n;
                        (n =
                            t instanceof Aa
                                ? t
                                : this._componentFactoryResolver.resolveComponentFactory(
                                      t
                                  )),
                            this.componentTypes.push(n.componentType);
                        const r = n.isBoundToModule
                                ? void 0
                                : this._injector.get(dl),
                            s = n.create(Ji.NULL, [], e || n.selector, r),
                            i = s.location.nativeElement,
                            o = s.injector.get(_c, null),
                            a = o && s.injector.get(kc);
                        return (
                            o && a && a.registerApplication(i, o),
                            s.onDestroy(() => {
                                this.detachView(s.hostView),
                                    Fc(this.components, s),
                                    a && a.unregisterApplication(i);
                            }),
                            this._loadComponent(s),
                            Oc() &&
                                this._console.log(
                                    "Angular is running in development mode. Call enableProdMode() to enable production mode."
                                ),
                            s
                        );
                    }
                    tick() {
                        if (this._runningTick)
                            throw new Error(
                                "ApplicationRef.tick is called recursively"
                            );
                        try {
                            this._runningTick = !0;
                            for (let t of this._views) t.detectChanges();
                        } catch (t) {
                            this._zone.runOutsideAngular(() =>
                                this._exceptionHandler.handleError(t)
                            );
                        } finally {
                            this._runningTick = !1;
                        }
                    }
                    attachView(t) {
                        const e = t;
                        this._views.push(e), e.attachToAppRef(this);
                    }
                    detachView(t) {
                        const e = t;
                        Fc(this._views, e), e.detachFromAppRef();
                    }
                    _loadComponent(t) {
                        this.attachView(t.hostView),
                            this.tick(),
                            this.components.push(t),
                            this._injector
                                .get(nc, [])
                                .concat(this._bootstrapListeners)
                                .forEach((e) => e(t));
                    }
                    ngOnDestroy() {
                        this._views.slice().forEach((t) => t.destroy()),
                            this._onMicrotaskEmptySubscription.unsubscribe();
                    }
                    get viewCount() {
                        return this._views.length;
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(
                            sr(mc),
                            sr(rc),
                            sr(Ji),
                            sr(Qr),
                            sr(Ia),
                            sr(Xl)
                        );
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            function Fc(t, e) {
                const n = t.indexOf(e);
                n > -1 && t.splice(n, 1);
            }
            const jc = Pc(null, "core", [
                    { provide: ec, useValue: "unknown" },
                    { provide: Nc, deps: [Ji] },
                    { provide: kc, deps: [] },
                    { provide: rc, deps: [] },
                ]),
                zc = [
                    {
                        provide: Vc,
                        useClass: Vc,
                        deps: [mc, rc, Ji, Qr, Ia, Xl],
                    },
                    {
                        provide: _l,
                        deps: [mc],
                        useFactory: function (t) {
                            let e = [];
                            return (
                                t.onStable.subscribe(() => {
                                    for (; e.length; ) e.pop()();
                                }),
                                function (t) {
                                    e.push(t);
                                }
                            );
                        },
                    },
                    { provide: Xl, useClass: Xl, deps: [[new lr(), Gl]] },
                    { provide: pc, useClass: pc, deps: [] },
                    Ql,
                    {
                        provide: Xa,
                        useFactory: function () {
                            return il;
                        },
                        deps: [],
                    },
                    {
                        provide: Qa,
                        useFactory: function () {
                            return ol;
                        },
                        deps: [],
                    },
                    {
                        provide: sc,
                        useFactory: function (t) {
                            return (
                                ka(
                                    (t =
                                        t ||
                                        ("undefined" != typeof $localize &&
                                            $localize.locale) ||
                                        "en-US")
                                ),
                                t
                            );
                        },
                        deps: [[new ar(sc), new lr(), new ur()]],
                    },
                    { provide: ic, useValue: "USD" },
                ];
            let Bc = (() => {
                    class t {
                        constructor(t) {}
                    }
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)(sr(Vc));
                            },
                            providers: zc,
                        })),
                        t
                    );
                })(),
                Hc = null;
            function Lc() {
                return Hc;
            }
            const qc = new Nn("DocumentToken");
            var Kc = (function (t) {
                return (
                    (t[(t.Zero = 0)] = "Zero"),
                    (t[(t.One = 1)] = "One"),
                    (t[(t.Two = 2)] = "Two"),
                    (t[(t.Few = 3)] = "Few"),
                    (t[(t.Many = 4)] = "Many"),
                    (t[(t.Other = 5)] = "Other"),
                    t
                );
            })({});
            class Wc {}
            let Uc = (() => {
                class t extends Wc {
                    constructor(t) {
                        super(), (this.locale = t);
                    }
                    getPluralCategory(t, e) {
                        switch (
                            (function (t) {
                                return (function (t) {
                                    const e = (function (t) {
                                        return t
                                            .toLowerCase()
                                            .replace(/_/g, "-");
                                    })(t);
                                    let n = Ca(e);
                                    if (n) return n;
                                    const r = e.split("-")[0];
                                    if (((n = Ca(r)), n)) return n;
                                    if ("en" === r) return ba;
                                    throw new Error(
                                        `Missing locale data for the locale "${t}".`
                                    );
                                })(t)[xa.PluralCase];
                            })(e || this.locale)(t)
                        ) {
                            case Kc.Zero:
                                return "zero";
                            case Kc.One:
                                return "one";
                            case Kc.Two:
                                return "two";
                            case Kc.Few:
                                return "few";
                            case Kc.Many:
                                return "many";
                            default:
                                return "other";
                        }
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(sc));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            function Zc(t, e) {
                e = encodeURIComponent(e);
                for (const n of t.split(";")) {
                    const t = n.indexOf("="),
                        [r, s] =
                            -1 == t ? [n, ""] : [n.slice(0, t), n.slice(t + 1)];
                    if (r.trim() === e) return decodeURIComponent(s);
                }
                return null;
            }
            let Yc = (() => {
                class t {
                    constructor(t, e, n, r) {
                        (this._iterableDiffers = t),
                            (this._keyValueDiffers = e),
                            (this._ngEl = n),
                            (this._renderer = r),
                            (this._iterableDiffer = null),
                            (this._keyValueDiffer = null),
                            (this._initialClasses = []),
                            (this._rawClass = null);
                    }
                    set klass(t) {
                        this._removeClasses(this._initialClasses),
                            (this._initialClasses =
                                "string" == typeof t ? t.split(/\s+/) : []),
                            this._applyClasses(this._initialClasses),
                            this._applyClasses(this._rawClass);
                    }
                    set ngClass(t) {
                        this._removeClasses(this._rawClass),
                            this._applyClasses(this._initialClasses),
                            (this._iterableDiffer = null),
                            (this._keyValueDiffer = null),
                            (this._rawClass =
                                "string" == typeof t ? t.split(/\s+/) : t),
                            this._rawClass &&
                                (no(this._rawClass)
                                    ? (this._iterableDiffer =
                                          this._iterableDiffers
                                              .find(this._rawClass)
                                              .create())
                                    : (this._keyValueDiffer =
                                          this._keyValueDiffers
                                              .find(this._rawClass)
                                              .create()));
                    }
                    ngDoCheck() {
                        if (this._iterableDiffer) {
                            const t = this._iterableDiffer.diff(this._rawClass);
                            t && this._applyIterableChanges(t);
                        } else if (this._keyValueDiffer) {
                            const t = this._keyValueDiffer.diff(this._rawClass);
                            t && this._applyKeyValueChanges(t);
                        }
                    }
                    _applyKeyValueChanges(t) {
                        t.forEachAddedItem((t) =>
                            this._toggleClass(t.key, t.currentValue)
                        ),
                            t.forEachChangedItem((t) =>
                                this._toggleClass(t.key, t.currentValue)
                            ),
                            t.forEachRemovedItem((t) => {
                                t.previousValue && this._toggleClass(t.key, !1);
                            });
                    }
                    _applyIterableChanges(t) {
                        t.forEachAddedItem((t) => {
                            if ("string" != typeof t.item)
                                throw new Error(
                                    `NgClass can only toggle CSS classes expressed as strings, got ${$(
                                        t.item
                                    )}`
                                );
                            this._toggleClass(t.item, !0);
                        }),
                            t.forEachRemovedItem((t) =>
                                this._toggleClass(t.item, !1)
                            );
                    }
                    _applyClasses(t) {
                        t &&
                            (Array.isArray(t) || t instanceof Set
                                ? t.forEach((t) => this._toggleClass(t, !0))
                                : Object.keys(t).forEach((e) =>
                                      this._toggleClass(e, !!t[e])
                                  ));
                    }
                    _removeClasses(t) {
                        t &&
                            (Array.isArray(t) || t instanceof Set
                                ? t.forEach((t) => this._toggleClass(t, !1))
                                : Object.keys(t).forEach((t) =>
                                      this._toggleClass(t, !1)
                                  ));
                    }
                    _toggleClass(t, e) {
                        (t = t.trim()) &&
                            t.split(/\s+/g).forEach((t) => {
                                e
                                    ? this._renderer.addClass(
                                          this._ngEl.nativeElement,
                                          t
                                      )
                                    : this._renderer.removeClass(
                                          this._ngEl.nativeElement,
                                          t
                                      );
                            });
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(Ro(Xa), Ro(Qa), Ro(Ma), Ro(Na));
                    }),
                    (t.ɵdir = Ht({
                        type: t,
                        selectors: [["", "ngClass", ""]],
                        inputs: {
                            klass: ["class", "klass"],
                            ngClass: "ngClass",
                        },
                    })),
                    t
                );
            })();
            class Gc {
                constructor(t, e, n, r) {
                    (this.$implicit = t),
                        (this.ngForOf = e),
                        (this.index = n),
                        (this.count = r);
                }
                get first() {
                    return 0 === this.index;
                }
                get last() {
                    return this.index === this.count - 1;
                }
                get even() {
                    return this.index % 2 == 0;
                }
                get odd() {
                    return !this.even;
                }
            }
            let Xc = (() => {
                class t {
                    constructor(t, e, n) {
                        (this._viewContainer = t),
                            (this._template = e),
                            (this._differs = n),
                            (this._ngForOf = null),
                            (this._ngForOfDirty = !0),
                            (this._differ = null);
                    }
                    set ngForOf(t) {
                        (this._ngForOf = t), (this._ngForOfDirty = !0);
                    }
                    set ngForTrackBy(t) {
                        this._trackByFn = t;
                    }
                    get ngForTrackBy() {
                        return this._trackByFn;
                    }
                    set ngForTemplate(t) {
                        t && (this._template = t);
                    }
                    ngDoCheck() {
                        if (this._ngForOfDirty) {
                            this._ngForOfDirty = !1;
                            const n = this._ngForOf;
                            if (!this._differ && n)
                                try {
                                    this._differ = this._differs
                                        .find(n)
                                        .create(this.ngForTrackBy);
                                } catch (e) {
                                    throw new Error(
                                        `Cannot find a differ supporting object '${n}' of type '${
                                            ((t = n), t.name || typeof t)
                                        }'. NgFor only supports binding to Iterables such as Arrays.`
                                    );
                                }
                        }
                        var t;
                        if (this._differ) {
                            const t = this._differ.diff(this._ngForOf);
                            t && this._applyChanges(t);
                        }
                    }
                    _applyChanges(t) {
                        const e = [];
                        t.forEachOperation((t, n, r) => {
                            if (null == t.previousIndex) {
                                const n =
                                        this._viewContainer.createEmbeddedView(
                                            this._template,
                                            new Gc(null, this._ngForOf, -1, -1),
                                            null === r ? void 0 : r
                                        ),
                                    s = new Jc(t, n);
                                e.push(s);
                            } else if (null == r)
                                this._viewContainer.remove(
                                    null === n ? void 0 : n
                                );
                            else if (null !== n) {
                                const s = this._viewContainer.get(n);
                                this._viewContainer.move(s, r);
                                const i = new Jc(t, s);
                                e.push(i);
                            }
                        });
                        for (let n = 0; n < e.length; n++)
                            this._perViewChange(e[n].view, e[n].record);
                        for (
                            let n = 0, r = this._viewContainer.length;
                            n < r;
                            n++
                        ) {
                            const t = this._viewContainer.get(n);
                            (t.context.index = n),
                                (t.context.count = r),
                                (t.context.ngForOf = this._ngForOf);
                        }
                        t.forEachIdentityChange((t) => {
                            this._viewContainer.get(
                                t.currentIndex
                            ).context.$implicit = t.item;
                        });
                    }
                    _perViewChange(t, e) {
                        t.context.$implicit = e.item;
                    }
                    static ngTemplateContextGuard(t, e) {
                        return !0;
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(Ro(fl), Ro(ll), Ro(Xa));
                    }),
                    (t.ɵdir = Ht({
                        type: t,
                        selectors: [["", "ngFor", "", "ngForOf", ""]],
                        inputs: {
                            ngForOf: "ngForOf",
                            ngForTrackBy: "ngForTrackBy",
                            ngForTemplate: "ngForTemplate",
                        },
                    })),
                    t
                );
            })();
            class Jc {
                constructor(t, e) {
                    (this.record = t), (this.view = e);
                }
            }
            let Qc = (() => {
                class t {
                    constructor(t, e) {
                        (this._viewContainer = t),
                            (this._context = new $c()),
                            (this._thenTemplateRef = null),
                            (this._elseTemplateRef = null),
                            (this._thenViewRef = null),
                            (this._elseViewRef = null),
                            (this._thenTemplateRef = e);
                    }
                    set ngIf(t) {
                        (this._context.$implicit = this._context.ngIf = t),
                            this._updateView();
                    }
                    set ngIfThen(t) {
                        tu("ngIfThen", t),
                            (this._thenTemplateRef = t),
                            (this._thenViewRef = null),
                            this._updateView();
                    }
                    set ngIfElse(t) {
                        tu("ngIfElse", t),
                            (this._elseTemplateRef = t),
                            (this._elseViewRef = null),
                            this._updateView();
                    }
                    _updateView() {
                        this._context.$implicit
                            ? this._thenViewRef ||
                              (this._viewContainer.clear(),
                              (this._elseViewRef = null),
                              this._thenTemplateRef &&
                                  (this._thenViewRef =
                                      this._viewContainer.createEmbeddedView(
                                          this._thenTemplateRef,
                                          this._context
                                      )))
                            : this._elseViewRef ||
                              (this._viewContainer.clear(),
                              (this._thenViewRef = null),
                              this._elseTemplateRef &&
                                  (this._elseViewRef =
                                      this._viewContainer.createEmbeddedView(
                                          this._elseTemplateRef,
                                          this._context
                                      )));
                    }
                    static ngTemplateContextGuard(t, e) {
                        return !0;
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(Ro(fl), Ro(ll));
                    }),
                    (t.ɵdir = Ht({
                        type: t,
                        selectors: [["", "ngIf", ""]],
                        inputs: {
                            ngIf: "ngIf",
                            ngIfThen: "ngIfThen",
                            ngIfElse: "ngIfElse",
                        },
                    })),
                    t
                );
            })();
            class $c {
                constructor() {
                    (this.$implicit = null), (this.ngIf = null);
                }
            }
            function tu(t, e) {
                if (e && !e.createEmbeddedView)
                    throw new Error(
                        `${t} must be a TemplateRef, but received '${$(e)}'.`
                    );
            }
            let eu = (() => {
                class t {}
                return (
                    (t.ɵmod = zt({ type: t })),
                    (t.ɵinj = it({
                        factory: function (e) {
                            return new (e || t)();
                        },
                        providers: [{ provide: Wc, useClass: Uc }],
                    })),
                    t
                );
            })();
            class nu extends class extends class {} {
                constructor() {
                    super();
                }
                supportsDOMEvents() {
                    return !0;
                }
            } {
                static makeCurrent() {
                    var t;
                    (t = new nu()), Hc || (Hc = t);
                }
                getProperty(t, e) {
                    return t[e];
                }
                log(t) {
                    window.console &&
                        window.console.log &&
                        window.console.log(t);
                }
                logGroup(t) {
                    window.console &&
                        window.console.group &&
                        window.console.group(t);
                }
                logGroupEnd() {
                    window.console &&
                        window.console.groupEnd &&
                        window.console.groupEnd();
                }
                onAndCancel(t, e, n) {
                    return (
                        t.addEventListener(e, n, !1),
                        () => {
                            t.removeEventListener(e, n, !1);
                        }
                    );
                }
                dispatchEvent(t, e) {
                    t.dispatchEvent(e);
                }
                remove(t) {
                    return t.parentNode && t.parentNode.removeChild(t), t;
                }
                getValue(t) {
                    return t.value;
                }
                createElement(t, e) {
                    return (e = e || this.getDefaultDocument()).createElement(
                        t
                    );
                }
                createHtmlDocument() {
                    return document.implementation.createHTMLDocument(
                        "fakeTitle"
                    );
                }
                getDefaultDocument() {
                    return document;
                }
                isElementNode(t) {
                    return t.nodeType === Node.ELEMENT_NODE;
                }
                isShadowRoot(t) {
                    return t instanceof DocumentFragment;
                }
                getGlobalEventTarget(t, e) {
                    return "window" === e
                        ? window
                        : "document" === e
                        ? t
                        : "body" === e
                        ? t.body
                        : null;
                }
                getHistory() {
                    return window.history;
                }
                getLocation() {
                    return window.location;
                }
                getBaseHref(t) {
                    const e =
                        su || ((su = document.querySelector("base")), su)
                            ? su.getAttribute("href")
                            : null;
                    return null == e
                        ? null
                        : ((n = e),
                          ru || (ru = document.createElement("a")),
                          ru.setAttribute("href", n),
                          "/" === ru.pathname.charAt(0)
                              ? ru.pathname
                              : "/" + ru.pathname);
                    var n;
                }
                resetBaseElement() {
                    su = null;
                }
                getUserAgent() {
                    return window.navigator.userAgent;
                }
                performanceNow() {
                    return window.performance && window.performance.now
                        ? window.performance.now()
                        : new Date().getTime();
                }
                supportsCookies() {
                    return !0;
                }
                getCookie(t) {
                    return Zc(document.cookie, t);
                }
            }
            let ru,
                su = null;
            const iu = new Nn("TRANSITION_ID"),
                ou = [
                    {
                        provide: Gl,
                        useFactory: function (t, e, n) {
                            return () => {
                                n.get(Xl).donePromise.then(() => {
                                    const n = Lc();
                                    Array.prototype.slice
                                        .apply(
                                            e.querySelectorAll(
                                                "style[ng-transition]"
                                            )
                                        )
                                        .filter(
                                            (e) =>
                                                e.getAttribute(
                                                    "ng-transition"
                                                ) === t
                                        )
                                        .forEach((t) => n.remove(t));
                                });
                            };
                        },
                        deps: [iu, qc, Ji],
                        multi: !0,
                    },
                ];
            class au {
                static init() {
                    var t;
                    (t = new au()), (Ic = t);
                }
                addToWindow(t) {
                    (kt.getAngularTestability = (e, n = !0) => {
                        const r = t.findTestabilityInTree(e, n);
                        if (null == r)
                            throw new Error(
                                "Could not find testability for element."
                            );
                        return r;
                    }),
                        (kt.getAllAngularTestabilities = () =>
                            t.getAllTestabilities()),
                        (kt.getAllAngularRootElements = () =>
                            t.getAllRootElements()),
                        kt.frameworkStabilizers ||
                            (kt.frameworkStabilizers = []),
                        kt.frameworkStabilizers.push((t) => {
                            const e = kt.getAllAngularTestabilities();
                            let n = e.length,
                                r = !1;
                            const s = function (e) {
                                (r = r || e), n--, 0 == n && t(r);
                            };
                            e.forEach(function (t) {
                                t.whenStable(s);
                            });
                        });
                }
                findTestabilityInTree(t, e, n) {
                    if (null == e) return null;
                    const r = t.getTestability(e);
                    return null != r
                        ? r
                        : n
                        ? Lc().isShadowRoot(e)
                            ? this.findTestabilityInTree(t, e.host, !0)
                            : this.findTestabilityInTree(t, e.parentElement, !0)
                        : null;
                }
            }
            const lu = new Nn("EventManagerPlugins");
            let cu = (() => {
                class t {
                    constructor(t, e) {
                        (this._zone = e),
                            (this._eventNameToPlugin = new Map()),
                            t.forEach((t) => (t.manager = this)),
                            (this._plugins = t.slice().reverse());
                    }
                    addEventListener(t, e, n) {
                        return this._findPluginFor(e).addEventListener(t, e, n);
                    }
                    addGlobalEventListener(t, e, n) {
                        return this._findPluginFor(e).addGlobalEventListener(
                            t,
                            e,
                            n
                        );
                    }
                    getZone() {
                        return this._zone;
                    }
                    _findPluginFor(t) {
                        const e = this._eventNameToPlugin.get(t);
                        if (e) return e;
                        const n = this._plugins;
                        for (let r = 0; r < n.length; r++) {
                            const e = n[r];
                            if (e.supports(t))
                                return this._eventNameToPlugin.set(t, e), e;
                        }
                        throw new Error(
                            `No event manager plugin found for event ${t}`
                        );
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(lu), sr(mc));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            class uu {
                constructor(t) {
                    this._doc = t;
                }
                addGlobalEventListener(t, e, n) {
                    const r = Lc().getGlobalEventTarget(this._doc, t);
                    if (!r)
                        throw new Error(
                            `Unsupported event target ${r} for event ${e}`
                        );
                    return this.addEventListener(r, e, n);
                }
            }
            let hu = (() => {
                    class t {
                        constructor() {
                            this._stylesSet = new Set();
                        }
                        addStyles(t) {
                            const e = new Set();
                            t.forEach((t) => {
                                this._stylesSet.has(t) ||
                                    (this._stylesSet.add(t), e.add(t));
                            }),
                                this.onStylesAdded(e);
                        }
                        onStylesAdded(t) {}
                        getAllStyles() {
                            return Array.from(this._stylesSet);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                du = (() => {
                    class t extends hu {
                        constructor(t) {
                            super(),
                                (this._doc = t),
                                (this._hostNodes = new Set()),
                                (this._styleNodes = new Set()),
                                this._hostNodes.add(t.head);
                        }
                        _addStylesToHost(t, e) {
                            t.forEach((t) => {
                                const n = this._doc.createElement("style");
                                (n.textContent = t),
                                    this._styleNodes.add(e.appendChild(n));
                            });
                        }
                        addHost(t) {
                            this._addStylesToHost(this._stylesSet, t),
                                this._hostNodes.add(t);
                        }
                        removeHost(t) {
                            this._hostNodes.delete(t);
                        }
                        onStylesAdded(t) {
                            this._hostNodes.forEach((e) =>
                                this._addStylesToHost(t, e)
                            );
                        }
                        ngOnDestroy() {
                            this._styleNodes.forEach((t) => Lc().remove(t));
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(qc));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })();
            const pu = {
                    svg: "http://www.w3.org/2000/svg",
                    xhtml: "http://www.w3.org/1999/xhtml",
                    xlink: "http://www.w3.org/1999/xlink",
                    xml: "http://www.w3.org/XML/1998/namespace",
                    xmlns: "http://www.w3.org/2000/xmlns/",
                },
                fu = /%COMP%/g;
            function gu(t, e, n) {
                for (let r = 0; r < e.length; r++) {
                    let s = e[r];
                    Array.isArray(s)
                        ? gu(t, s, n)
                        : ((s = s.replace(fu, t)), n.push(s));
                }
                return n;
            }
            function mu(t) {
                return (e) => {
                    if ("__ngUnwrap__" === e) return t;
                    !1 === t(e) && (e.preventDefault(), (e.returnValue = !1));
                };
            }
            let yu = (() => {
                class t {
                    constructor(t, e, n) {
                        (this.eventManager = t),
                            (this.sharedStylesHost = e),
                            (this.appId = n),
                            (this.rendererByCompId = new Map()),
                            (this.defaultRenderer = new vu(t));
                    }
                    createRenderer(t, e) {
                        if (!t || !e) return this.defaultRenderer;
                        switch (e.encapsulation) {
                            case bt.Emulated: {
                                let n = this.rendererByCompId.get(e.id);
                                return (
                                    n ||
                                        ((n = new bu(
                                            this.eventManager,
                                            this.sharedStylesHost,
                                            e,
                                            this.appId
                                        )),
                                        this.rendererByCompId.set(e.id, n)),
                                    n.applyToHost(t),
                                    n
                                );
                            }
                            case 1:
                            case bt.ShadowDom:
                                return new wu(
                                    this.eventManager,
                                    this.sharedStylesHost,
                                    t,
                                    e
                                );
                            default:
                                if (!this.rendererByCompId.has(e.id)) {
                                    const t = gu(e.id, e.styles, []);
                                    this.sharedStylesHost.addStyles(t),
                                        this.rendererByCompId.set(
                                            e.id,
                                            this.defaultRenderer
                                        );
                                }
                                return this.defaultRenderer;
                        }
                    }
                    begin() {}
                    end() {}
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(cu), sr(du), sr(Jl));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            class vu {
                constructor(t) {
                    (this.eventManager = t), (this.data = Object.create(null));
                }
                destroy() {}
                createElement(t, e) {
                    return e
                        ? document.createElementNS(pu[e] || e, t)
                        : document.createElement(t);
                }
                createComment(t) {
                    return document.createComment(t);
                }
                createText(t) {
                    return document.createTextNode(t);
                }
                appendChild(t, e) {
                    t.appendChild(e);
                }
                insertBefore(t, e, n) {
                    t && t.insertBefore(e, n);
                }
                removeChild(t, e) {
                    t && t.removeChild(e);
                }
                selectRootElement(t, e) {
                    let n =
                        "string" == typeof t ? document.querySelector(t) : t;
                    if (!n)
                        throw new Error(
                            `The selector "${t}" did not match any elements`
                        );
                    return e || (n.textContent = ""), n;
                }
                parentNode(t) {
                    return t.parentNode;
                }
                nextSibling(t) {
                    return t.nextSibling;
                }
                setAttribute(t, e, n, r) {
                    if (r) {
                        e = r + ":" + e;
                        const s = pu[r];
                        s ? t.setAttributeNS(s, e, n) : t.setAttribute(e, n);
                    } else t.setAttribute(e, n);
                }
                removeAttribute(t, e, n) {
                    if (n) {
                        const r = pu[n];
                        r
                            ? t.removeAttributeNS(r, e)
                            : t.removeAttribute(`${n}:${e}`);
                    } else t.removeAttribute(e);
                }
                addClass(t, e) {
                    t.classList.add(e);
                }
                removeClass(t, e) {
                    t.classList.remove(e);
                }
                setStyle(t, e, n, r) {
                    r & (rs.DashCase | rs.Important)
                        ? t.style.setProperty(
                              e,
                              n,
                              r & rs.Important ? "important" : ""
                          )
                        : (t.style[e] = n);
                }
                removeStyle(t, e, n) {
                    n & rs.DashCase
                        ? t.style.removeProperty(e)
                        : (t.style[e] = "");
                }
                setProperty(t, e, n) {
                    t[e] = n;
                }
                setValue(t, e) {
                    t.nodeValue = e;
                }
                listen(t, e, n) {
                    return "string" == typeof t
                        ? this.eventManager.addGlobalEventListener(t, e, mu(n))
                        : this.eventManager.addEventListener(t, e, mu(n));
                }
            }
            class bu extends vu {
                constructor(t, e, n, r) {
                    super(t), (this.component = n);
                    const s = gu(r + "-" + n.id, n.styles, []);
                    e.addStyles(s),
                        (this.contentAttr = "_ngcontent-%COMP%".replace(
                            fu,
                            r + "-" + n.id
                        )),
                        (this.hostAttr = "_nghost-%COMP%".replace(
                            fu,
                            r + "-" + n.id
                        ));
                }
                applyToHost(t) {
                    super.setAttribute(t, this.hostAttr, "");
                }
                createElement(t, e) {
                    const n = super.createElement(t, e);
                    return super.setAttribute(n, this.contentAttr, ""), n;
                }
            }
            class wu extends vu {
                constructor(t, e, n, r) {
                    super(t),
                        (this.sharedStylesHost = e),
                        (this.hostEl = n),
                        (this.shadowRoot = n.attachShadow({ mode: "open" })),
                        this.sharedStylesHost.addHost(this.shadowRoot);
                    const s = gu(r.id, r.styles, []);
                    for (let i = 0; i < s.length; i++) {
                        const t = document.createElement("style");
                        (t.textContent = s[i]), this.shadowRoot.appendChild(t);
                    }
                }
                nodeOrShadowRoot(t) {
                    return t === this.hostEl ? this.shadowRoot : t;
                }
                destroy() {
                    this.sharedStylesHost.removeHost(this.shadowRoot);
                }
                appendChild(t, e) {
                    return super.appendChild(this.nodeOrShadowRoot(t), e);
                }
                insertBefore(t, e, n) {
                    return super.insertBefore(this.nodeOrShadowRoot(t), e, n);
                }
                removeChild(t, e) {
                    return super.removeChild(this.nodeOrShadowRoot(t), e);
                }
                parentNode(t) {
                    return this.nodeOrShadowRoot(
                        super.parentNode(this.nodeOrShadowRoot(t))
                    );
                }
            }
            let Cu = (() => {
                class t extends uu {
                    constructor(t) {
                        super(t);
                    }
                    supports(t) {
                        return !0;
                    }
                    addEventListener(t, e, n) {
                        return (
                            t.addEventListener(e, n, !1),
                            () => this.removeEventListener(t, e, n)
                        );
                    }
                    removeEventListener(t, e, n) {
                        return t.removeEventListener(e, n);
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(qc));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            const xu = ["alt", "control", "meta", "shift"],
                _u = {
                    "\b": "Backspace",
                    "\t": "Tab",
                    "\x7f": "Delete",
                    "\x1b": "Escape",
                    Del: "Delete",
                    Esc: "Escape",
                    Left: "ArrowLeft",
                    Right: "ArrowRight",
                    Up: "ArrowUp",
                    Down: "ArrowDown",
                    Menu: "ContextMenu",
                    Scroll: "ScrollLock",
                    Win: "OS",
                },
                ku = {
                    A: "1",
                    B: "2",
                    C: "3",
                    D: "4",
                    E: "5",
                    F: "6",
                    G: "7",
                    H: "8",
                    I: "9",
                    J: "*",
                    K: "+",
                    M: "-",
                    N: ".",
                    O: "/",
                    "`": "0",
                    "\x90": "NumLock",
                },
                Au = {
                    alt: (t) => t.altKey,
                    control: (t) => t.ctrlKey,
                    meta: (t) => t.metaKey,
                    shift: (t) => t.shiftKey,
                };
            let Eu = (() => {
                    class t extends uu {
                        constructor(t) {
                            super(t);
                        }
                        supports(e) {
                            return null != t.parseEventName(e);
                        }
                        addEventListener(e, n, r) {
                            const s = t.parseEventName(n),
                                i = t.eventCallback(
                                    s.fullKey,
                                    r,
                                    this.manager.getZone()
                                );
                            return this.manager
                                .getZone()
                                .runOutsideAngular(() =>
                                    Lc().onAndCancel(e, s.domEventName, i)
                                );
                        }
                        static parseEventName(e) {
                            const n = e.toLowerCase().split("."),
                                r = n.shift();
                            if (
                                0 === n.length ||
                                ("keydown" !== r && "keyup" !== r)
                            )
                                return null;
                            const s = t._normalizeKey(n.pop());
                            let i = "";
                            if (
                                (xu.forEach((t) => {
                                    const e = n.indexOf(t);
                                    e > -1 && (n.splice(e, 1), (i += t + "."));
                                }),
                                (i += s),
                                0 != n.length || 0 === s.length)
                            )
                                return null;
                            const o = {};
                            return (o.domEventName = r), (o.fullKey = i), o;
                        }
                        static getEventFullKey(t) {
                            let e = "",
                                n = (function (t) {
                                    let e = t.key;
                                    if (null == e) {
                                        if (((e = t.keyIdentifier), null == e))
                                            return "Unidentified";
                                        e.startsWith("U+") &&
                                            ((e = String.fromCharCode(
                                                parseInt(e.substring(2), 16)
                                            )),
                                            3 === t.location &&
                                                ku.hasOwnProperty(e) &&
                                                (e = ku[e]));
                                    }
                                    return _u[e] || e;
                                })(t);
                            return (
                                (n = n.toLowerCase()),
                                " " === n
                                    ? (n = "space")
                                    : "." === n && (n = "dot"),
                                xu.forEach((r) => {
                                    r != n && (0, Au[r])(t) && (e += r + ".");
                                }),
                                (e += n),
                                e
                            );
                        }
                        static eventCallback(e, n, r) {
                            return (s) => {
                                t.getEventFullKey(s) === e &&
                                    r.runGuarded(() => n(s));
                            };
                        }
                        static _normalizeKey(t) {
                            switch (t) {
                                case "esc":
                                    return "escape";
                                default:
                                    return t;
                            }
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(qc));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                Iu = (() => {
                    class t {}
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({
                            factory: function () {
                                return sr(Tu);
                            },
                            token: t,
                            providedIn: "root",
                        })),
                        t
                    );
                })(),
                Tu = (() => {
                    class t extends Iu {
                        constructor(t) {
                            super(), (this._doc = t);
                        }
                        sanitize(t, e) {
                            if (null == e) return null;
                            switch (t) {
                                case Zr.NONE:
                                    return e;
                                case Zr.HTML:
                                    return xr(e, "HTML")
                                        ? Cr(e)
                                        : Wr(this._doc, String(e)).toString();
                                case Zr.STYLE:
                                    return xr(e, "Style") ? Cr(e) : e;
                                case Zr.SCRIPT:
                                    if (xr(e, "Script")) return Cr(e);
                                    throw new Error(
                                        "unsafe value used in a script context"
                                    );
                                case Zr.URL:
                                    return (
                                        _r(e),
                                        xr(e, "URL") ? Cr(e) : Tr(String(e))
                                    );
                                case Zr.RESOURCE_URL:
                                    if (xr(e, "ResourceURL")) return Cr(e);
                                    throw new Error(
                                        "unsafe value used in a resource URL context (see https://g.co/ng/security#xss)"
                                    );
                                default:
                                    throw new Error(
                                        `Unexpected SecurityContext ${t} (see https://g.co/ng/security#xss)`
                                    );
                            }
                        }
                        bypassSecurityTrustHtml(t) {
                            return new mr(t);
                        }
                        bypassSecurityTrustStyle(t) {
                            return new yr(t);
                        }
                        bypassSecurityTrustScript(t) {
                            return new vr(t);
                        }
                        bypassSecurityTrustUrl(t) {
                            return new br(t);
                        }
                        bypassSecurityTrustResourceUrl(t) {
                            return new wr(t);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(qc));
                        }),
                        (t.ɵprov = st({
                            factory: function () {
                                return (t = sr(Vi)), new Tu(t.get(qc));
                                var t;
                            },
                            token: t,
                            providedIn: "root",
                        })),
                        t
                    );
                })();
            const Su = Pc(jc, "browser", [
                    { provide: ec, useValue: "browser" },
                    {
                        provide: tc,
                        useValue: function () {
                            nu.makeCurrent(), au.init();
                        },
                        multi: !0,
                    },
                    {
                        provide: qc,
                        useFactory: function () {
                            return (
                                (function (t) {
                                    ae = t;
                                })(document),
                                document
                            );
                        },
                        deps: [],
                    },
                ]),
                Ou = [
                    [],
                    { provide: ji, useValue: "root" },
                    {
                        provide: Qr,
                        useFactory: function () {
                            return new Qr();
                        },
                        deps: [],
                    },
                    {
                        provide: lu,
                        useClass: Cu,
                        multi: !0,
                        deps: [qc, mc, ec],
                    },
                    { provide: lu, useClass: Eu, multi: !0, deps: [qc] },
                    [],
                    { provide: yu, useClass: yu, deps: [cu, du, Jl] },
                    { provide: Ra, useExisting: yu },
                    { provide: hu, useExisting: du },
                    { provide: du, useClass: du, deps: [qc] },
                    { provide: _c, useClass: _c, deps: [mc] },
                    { provide: cu, useClass: cu, deps: [lu, mc] },
                    [],
                ];
            let Mu = (() => {
                class t {
                    constructor(t) {
                        if (t)
                            throw new Error(
                                "BrowserModule has already been loaded. If you need access to common directives such as NgIf and NgFor from a lazy loaded module, import CommonModule instead."
                            );
                    }
                    static withServerTransition(e) {
                        return {
                            ngModule: t,
                            providers: [
                                { provide: Jl, useValue: e.appId },
                                { provide: iu, useExisting: Jl },
                                ou,
                            ],
                        };
                    }
                }
                return (
                    (t.ɵmod = zt({ type: t })),
                    (t.ɵinj = it({
                        factory: function (e) {
                            return new (e || t)(sr(t, 12));
                        },
                        providers: Ou,
                        imports: [eu, Bc],
                    })),
                    t
                );
            })();
            function Pu(...t) {
                let e = t[t.length - 1];
                return A(e) ? (t.pop(), D(t, e)) : q(t);
            }
            "undefined" != typeof window && window;
            class Ru {
                constructor(t, e) {
                    (this.predicate = t), (this.thisArg = e);
                }
                call(t, e) {
                    return e.subscribe(new Nu(t, this.predicate, this.thisArg));
                }
            }
            class Nu extends f {
                constructor(t, e, n) {
                    super(t),
                        (this.predicate = e),
                        (this.thisArg = n),
                        (this.count = 0);
                }
                _next(t) {
                    let e;
                    try {
                        e = this.predicate.call(this.thisArg, t, this.count++);
                    } catch (n) {
                        return void this.destination.error(n);
                    }
                    e && this.destination.next(t);
                }
            }
            class Du {}
            class Vu {}
            class Fu {
                constructor(t) {
                    (this.normalizedNames = new Map()),
                        (this.lazyUpdate = null),
                        t
                            ? (this.lazyInit =
                                  "string" == typeof t
                                      ? () => {
                                            (this.headers = new Map()),
                                                t.split("\n").forEach((t) => {
                                                    const e = t.indexOf(":");
                                                    if (e > 0) {
                                                        const n = t.slice(0, e),
                                                            r = n.toLowerCase(),
                                                            s = t
                                                                .slice(e + 1)
                                                                .trim();
                                                        this.maybeSetNormalizedName(
                                                            n,
                                                            r
                                                        ),
                                                            this.headers.has(r)
                                                                ? this.headers
                                                                      .get(r)
                                                                      .push(s)
                                                                : this.headers.set(
                                                                      r,
                                                                      [s]
                                                                  );
                                                    }
                                                });
                                        }
                                      : () => {
                                            (this.headers = new Map()),
                                                Object.keys(t).forEach((e) => {
                                                    let n = t[e];
                                                    const r = e.toLowerCase();
                                                    "string" == typeof n &&
                                                        (n = [n]),
                                                        n.length > 0 &&
                                                            (this.headers.set(
                                                                r,
                                                                n
                                                            ),
                                                            this.maybeSetNormalizedName(
                                                                e,
                                                                r
                                                            ));
                                                });
                                        })
                            : (this.headers = new Map());
                }
                has(t) {
                    return this.init(), this.headers.has(t.toLowerCase());
                }
                get(t) {
                    this.init();
                    const e = this.headers.get(t.toLowerCase());
                    return e && e.length > 0 ? e[0] : null;
                }
                keys() {
                    return (
                        this.init(), Array.from(this.normalizedNames.values())
                    );
                }
                getAll(t) {
                    return (
                        this.init(), this.headers.get(t.toLowerCase()) || null
                    );
                }
                append(t, e) {
                    return this.clone({ name: t, value: e, op: "a" });
                }
                set(t, e) {
                    return this.clone({ name: t, value: e, op: "s" });
                }
                delete(t, e) {
                    return this.clone({ name: t, value: e, op: "d" });
                }
                maybeSetNormalizedName(t, e) {
                    this.normalizedNames.has(e) ||
                        this.normalizedNames.set(e, t);
                }
                init() {
                    this.lazyInit &&
                        (this.lazyInit instanceof Fu
                            ? this.copyFrom(this.lazyInit)
                            : this.lazyInit(),
                        (this.lazyInit = null),
                        this.lazyUpdate &&
                            (this.lazyUpdate.forEach((t) =>
                                this.applyUpdate(t)
                            ),
                            (this.lazyUpdate = null)));
                }
                copyFrom(t) {
                    t.init(),
                        Array.from(t.headers.keys()).forEach((e) => {
                            this.headers.set(e, t.headers.get(e)),
                                this.normalizedNames.set(
                                    e,
                                    t.normalizedNames.get(e)
                                );
                        });
                }
                clone(t) {
                    const e = new Fu();
                    return (
                        (e.lazyInit =
                            this.lazyInit && this.lazyInit instanceof Fu
                                ? this.lazyInit
                                : this),
                        (e.lazyUpdate = (this.lazyUpdate || []).concat([t])),
                        e
                    );
                }
                applyUpdate(t) {
                    const e = t.name.toLowerCase();
                    switch (t.op) {
                        case "a":
                        case "s":
                            let n = t.value;
                            if (
                                ("string" == typeof n && (n = [n]),
                                0 === n.length)
                            )
                                return;
                            this.maybeSetNormalizedName(t.name, e);
                            const r =
                                ("a" === t.op ? this.headers.get(e) : void 0) ||
                                [];
                            r.push(...n), this.headers.set(e, r);
                            break;
                        case "d":
                            const s = t.value;
                            if (s) {
                                let t = this.headers.get(e);
                                if (!t) return;
                                (t = t.filter((t) => -1 === s.indexOf(t))),
                                    0 === t.length
                                        ? (this.headers.delete(e),
                                          this.normalizedNames.delete(e))
                                        : this.headers.set(e, t);
                            } else
                                this.headers.delete(e),
                                    this.normalizedNames.delete(e);
                    }
                }
                forEach(t) {
                    this.init(),
                        Array.from(this.normalizedNames.keys()).forEach((e) =>
                            t(this.normalizedNames.get(e), this.headers.get(e))
                        );
                }
            }
            class ju {
                encodeKey(t) {
                    return zu(t);
                }
                encodeValue(t) {
                    return zu(t);
                }
                decodeKey(t) {
                    return decodeURIComponent(t);
                }
                decodeValue(t) {
                    return decodeURIComponent(t);
                }
            }
            function zu(t) {
                return encodeURIComponent(t)
                    .replace(/%40/gi, "@")
                    .replace(/%3A/gi, ":")
                    .replace(/%24/gi, "$")
                    .replace(/%2C/gi, ",")
                    .replace(/%3B/gi, ";")
                    .replace(/%2B/gi, "+")
                    .replace(/%3D/gi, "=")
                    .replace(/%3F/gi, "?")
                    .replace(/%2F/gi, "/");
            }
            class Bu {
                constructor(t = {}) {
                    if (
                        ((this.updates = null),
                        (this.cloneFrom = null),
                        (this.encoder = t.encoder || new ju()),
                        t.fromString)
                    ) {
                        if (t.fromObject)
                            throw new Error(
                                "Cannot specify both fromString and fromObject."
                            );
                        this.map = (function (t, e) {
                            const n = new Map();
                            return (
                                t.length > 0 &&
                                    t.split("&").forEach((t) => {
                                        const r = t.indexOf("="),
                                            [s, i] =
                                                -1 == r
                                                    ? [e.decodeKey(t), ""]
                                                    : [
                                                          e.decodeKey(
                                                              t.slice(0, r)
                                                          ),
                                                          e.decodeValue(
                                                              t.slice(r + 1)
                                                          ),
                                                      ],
                                            o = n.get(s) || [];
                                        o.push(i), n.set(s, o);
                                    }),
                                n
                            );
                        })(t.fromString, this.encoder);
                    } else
                        t.fromObject
                            ? ((this.map = new Map()),
                              Object.keys(t.fromObject).forEach((e) => {
                                  const n = t.fromObject[e];
                                  this.map.set(e, Array.isArray(n) ? n : [n]);
                              }))
                            : (this.map = null);
                }
                has(t) {
                    return this.init(), this.map.has(t);
                }
                get(t) {
                    this.init();
                    const e = this.map.get(t);
                    return e ? e[0] : null;
                }
                getAll(t) {
                    return this.init(), this.map.get(t) || null;
                }
                keys() {
                    return this.init(), Array.from(this.map.keys());
                }
                append(t, e) {
                    return this.clone({ param: t, value: e, op: "a" });
                }
                set(t, e) {
                    return this.clone({ param: t, value: e, op: "s" });
                }
                delete(t, e) {
                    return this.clone({ param: t, value: e, op: "d" });
                }
                toString() {
                    return (
                        this.init(),
                        this.keys()
                            .map((t) => {
                                const e = this.encoder.encodeKey(t);
                                return this.map
                                    .get(t)
                                    .map(
                                        (t) =>
                                            e +
                                            "=" +
                                            this.encoder.encodeValue(t)
                                    )
                                    .join("&");
                            })
                            .filter((t) => "" !== t)
                            .join("&")
                    );
                }
                clone(t) {
                    const e = new Bu({ encoder: this.encoder });
                    return (
                        (e.cloneFrom = this.cloneFrom || this),
                        (e.updates = (this.updates || []).concat([t])),
                        e
                    );
                }
                init() {
                    null === this.map && (this.map = new Map()),
                        null !== this.cloneFrom &&
                            (this.cloneFrom.init(),
                            this.cloneFrom
                                .keys()
                                .forEach((t) =>
                                    this.map.set(t, this.cloneFrom.map.get(t))
                                ),
                            this.updates.forEach((t) => {
                                switch (t.op) {
                                    case "a":
                                    case "s":
                                        const e =
                                            ("a" === t.op
                                                ? this.map.get(t.param)
                                                : void 0) || [];
                                        e.push(t.value),
                                            this.map.set(t.param, e);
                                        break;
                                    case "d":
                                        if (void 0 === t.value) {
                                            this.map.delete(t.param);
                                            break;
                                        }
                                        {
                                            let e = this.map.get(t.param) || [];
                                            const n = e.indexOf(t.value);
                                            -1 !== n && e.splice(n, 1),
                                                e.length > 0
                                                    ? this.map.set(t.param, e)
                                                    : this.map.delete(t.param);
                                        }
                                }
                            }),
                            (this.cloneFrom = this.updates = null));
                }
            }
            function Hu(t) {
                return (
                    "undefined" != typeof ArrayBuffer &&
                    t instanceof ArrayBuffer
                );
            }
            function Lu(t) {
                return "undefined" != typeof Blob && t instanceof Blob;
            }
            function qu(t) {
                return "undefined" != typeof FormData && t instanceof FormData;
            }
            class Ku {
                constructor(t, e, n, r) {
                    let s;
                    if (
                        ((this.url = e),
                        (this.body = null),
                        (this.reportProgress = !1),
                        (this.withCredentials = !1),
                        (this.responseType = "json"),
                        (this.method = t.toUpperCase()),
                        (function (t) {
                            switch (t) {
                                case "DELETE":
                                case "GET":
                                case "HEAD":
                                case "OPTIONS":
                                case "JSONP":
                                    return !1;
                                default:
                                    return !0;
                            }
                        })(this.method) || r
                            ? ((this.body = void 0 !== n ? n : null), (s = r))
                            : (s = n),
                        s &&
                            ((this.reportProgress = !!s.reportProgress),
                            (this.withCredentials = !!s.withCredentials),
                            s.responseType &&
                                (this.responseType = s.responseType),
                            s.headers && (this.headers = s.headers),
                            s.params && (this.params = s.params)),
                        this.headers || (this.headers = new Fu()),
                        this.params)
                    ) {
                        const t = this.params.toString();
                        if (0 === t.length) this.urlWithParams = e;
                        else {
                            const n = e.indexOf("?");
                            this.urlWithParams =
                                e +
                                (-1 === n ? "?" : n < e.length - 1 ? "&" : "") +
                                t;
                        }
                    } else (this.params = new Bu()), (this.urlWithParams = e);
                }
                serializeBody() {
                    return null === this.body
                        ? null
                        : Hu(this.body) ||
                          Lu(this.body) ||
                          qu(this.body) ||
                          "string" == typeof this.body
                        ? this.body
                        : this.body instanceof Bu
                        ? this.body.toString()
                        : "object" == typeof this.body ||
                          "boolean" == typeof this.body ||
                          Array.isArray(this.body)
                        ? JSON.stringify(this.body)
                        : this.body.toString();
                }
                detectContentTypeHeader() {
                    return null === this.body || qu(this.body)
                        ? null
                        : Lu(this.body)
                        ? this.body.type || null
                        : Hu(this.body)
                        ? null
                        : "string" == typeof this.body
                        ? "text/plain"
                        : this.body instanceof Bu
                        ? "application/x-www-form-urlencoded;charset=UTF-8"
                        : "object" == typeof this.body ||
                          "number" == typeof this.body ||
                          Array.isArray(this.body)
                        ? "application/json"
                        : null;
                }
                clone(t = {}) {
                    const e = t.method || this.method,
                        n = t.url || this.url,
                        r = t.responseType || this.responseType,
                        s = void 0 !== t.body ? t.body : this.body,
                        i =
                            void 0 !== t.withCredentials
                                ? t.withCredentials
                                : this.withCredentials,
                        o =
                            void 0 !== t.reportProgress
                                ? t.reportProgress
                                : this.reportProgress;
                    let a = t.headers || this.headers,
                        l = t.params || this.params;
                    return (
                        void 0 !== t.setHeaders &&
                            (a = Object.keys(t.setHeaders).reduce(
                                (e, n) => e.set(n, t.setHeaders[n]),
                                a
                            )),
                        t.setParams &&
                            (l = Object.keys(t.setParams).reduce(
                                (e, n) => e.set(n, t.setParams[n]),
                                l
                            )),
                        new Ku(e, n, s, {
                            params: l,
                            headers: a,
                            reportProgress: o,
                            responseType: r,
                            withCredentials: i,
                        })
                    );
                }
            }
            var Wu = (function (t) {
                return (
                    (t[(t.Sent = 0)] = "Sent"),
                    (t[(t.UploadProgress = 1)] = "UploadProgress"),
                    (t[(t.ResponseHeader = 2)] = "ResponseHeader"),
                    (t[(t.DownloadProgress = 3)] = "DownloadProgress"),
                    (t[(t.Response = 4)] = "Response"),
                    (t[(t.User = 5)] = "User"),
                    t
                );
            })({});
            class Uu {
                constructor(t, e = 200, n = "OK") {
                    (this.headers = t.headers || new Fu()),
                        (this.status = void 0 !== t.status ? t.status : e),
                        (this.statusText = t.statusText || n),
                        (this.url = t.url || null),
                        (this.ok = this.status >= 200 && this.status < 300);
                }
            }
            class Zu extends Uu {
                constructor(t = {}) {
                    super(t), (this.type = Wu.ResponseHeader);
                }
                clone(t = {}) {
                    return new Zu({
                        headers: t.headers || this.headers,
                        status: void 0 !== t.status ? t.status : this.status,
                        statusText: t.statusText || this.statusText,
                        url: t.url || this.url || void 0,
                    });
                }
            }
            class Yu extends Uu {
                constructor(t = {}) {
                    super(t),
                        (this.type = Wu.Response),
                        (this.body = void 0 !== t.body ? t.body : null);
                }
                clone(t = {}) {
                    return new Yu({
                        body: void 0 !== t.body ? t.body : this.body,
                        headers: t.headers || this.headers,
                        status: void 0 !== t.status ? t.status : this.status,
                        statusText: t.statusText || this.statusText,
                        url: t.url || this.url || void 0,
                    });
                }
            }
            class Gu extends Uu {
                constructor(t) {
                    super(t, 0, "Unknown Error"),
                        (this.name = "HttpErrorResponse"),
                        (this.ok = !1),
                        (this.message =
                            this.status >= 200 && this.status < 300
                                ? `Http failure during parsing for ${
                                      t.url || "(unknown url)"
                                  }`
                                : `Http failure response for ${
                                      t.url || "(unknown url)"
                                  }: ${t.status} ${t.statusText}`),
                        (this.error = t.error || null);
                }
            }
            function Xu(t, e) {
                return {
                    body: e,
                    headers: t.headers,
                    observe: t.observe,
                    params: t.params,
                    reportProgress: t.reportProgress,
                    responseType: t.responseType,
                    withCredentials: t.withCredentials,
                };
            }
            let Ju = (() => {
                class t {
                    constructor(t) {
                        this.handler = t;
                    }
                    request(t, e, n = {}) {
                        let r;
                        if (t instanceof Ku) r = t;
                        else {
                            let s, i;
                            (s =
                                n.headers instanceof Fu
                                    ? n.headers
                                    : new Fu(n.headers)),
                                n.params &&
                                    (i =
                                        n.params instanceof Bu
                                            ? n.params
                                            : new Bu({ fromObject: n.params })),
                                (r = new Ku(
                                    t,
                                    e,
                                    void 0 !== n.body ? n.body : null,
                                    {
                                        headers: s,
                                        params: i,
                                        reportProgress: n.reportProgress,
                                        responseType: n.responseType || "json",
                                        withCredentials: n.withCredentials,
                                    }
                                ));
                        }
                        const s = Pu(r).pipe(
                            B((t) => this.handler.handle(t), void 0, 1)
                        );
                        if (t instanceof Ku || "events" === n.observe) return s;
                        const i = s.pipe(
                            ((o = (t) => t instanceof Yu),
                            function (t) {
                                return t.lift(new Ru(o, void 0));
                            })
                        );
                        var o;
                        switch (n.observe || "body") {
                            case "body":
                                switch (r.responseType) {
                                    case "arraybuffer":
                                        return i.pipe(
                                            E((t) => {
                                                if (
                                                    null !== t.body &&
                                                    !(
                                                        t.body instanceof
                                                        ArrayBuffer
                                                    )
                                                )
                                                    throw new Error(
                                                        "Response is not an ArrayBuffer."
                                                    );
                                                return t.body;
                                            })
                                        );
                                    case "blob":
                                        return i.pipe(
                                            E((t) => {
                                                if (
                                                    null !== t.body &&
                                                    !(t.body instanceof Blob)
                                                )
                                                    throw new Error(
                                                        "Response is not a Blob."
                                                    );
                                                return t.body;
                                            })
                                        );
                                    case "text":
                                        return i.pipe(
                                            E((t) => {
                                                if (
                                                    null !== t.body &&
                                                    "string" != typeof t.body
                                                )
                                                    throw new Error(
                                                        "Response is not a string."
                                                    );
                                                return t.body;
                                            })
                                        );
                                    case "json":
                                    default:
                                        return i.pipe(E((t) => t.body));
                                }
                            case "response":
                                return i;
                            default:
                                throw new Error(
                                    `Unreachable: unhandled observe type ${n.observe}}`
                                );
                        }
                    }
                    delete(t, e = {}) {
                        return this.request("DELETE", t, e);
                    }
                    get(t, e = {}) {
                        return this.request("GET", t, e);
                    }
                    head(t, e = {}) {
                        return this.request("HEAD", t, e);
                    }
                    jsonp(t, e) {
                        return this.request("JSONP", t, {
                            params: new Bu().append(e, "JSONP_CALLBACK"),
                            observe: "body",
                            responseType: "json",
                        });
                    }
                    options(t, e = {}) {
                        return this.request("OPTIONS", t, e);
                    }
                    patch(t, e, n = {}) {
                        return this.request("PATCH", t, Xu(n, e));
                    }
                    post(t, e, n = {}) {
                        return this.request("POST", t, Xu(n, e));
                    }
                    put(t, e, n = {}) {
                        return this.request("PUT", t, Xu(n, e));
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(Du));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            class Qu {
                constructor(t, e) {
                    (this.next = t), (this.interceptor = e);
                }
                handle(t) {
                    return this.interceptor.intercept(t, this.next);
                }
            }
            const $u = new Nn("HTTP_INTERCEPTORS");
            let th = (() => {
                class t {
                    intercept(t, e) {
                        return e.handle(t);
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)();
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            const eh = /^\)\]\}',?\n/;
            class nh {}
            let rh = (() => {
                    class t {
                        constructor() {}
                        build() {
                            return new XMLHttpRequest();
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                sh = (() => {
                    class t {
                        constructor(t) {
                            this.xhrFactory = t;
                        }
                        handle(t) {
                            if ("JSONP" === t.method)
                                throw new Error(
                                    "Attempted to construct Jsonp request without HttpClientJsonpModule installed."
                                );
                            return new v((e) => {
                                const n = this.xhrFactory.build();
                                if (
                                    (n.open(t.method, t.urlWithParams),
                                    t.withCredentials &&
                                        (n.withCredentials = !0),
                                    t.headers.forEach((t, e) =>
                                        n.setRequestHeader(t, e.join(","))
                                    ),
                                    t.headers.has("Accept") ||
                                        n.setRequestHeader(
                                            "Accept",
                                            "application/json, text/plain, */*"
                                        ),
                                    !t.headers.has("Content-Type"))
                                ) {
                                    const e = t.detectContentTypeHeader();
                                    null !== e &&
                                        n.setRequestHeader("Content-Type", e);
                                }
                                if (t.responseType) {
                                    const e = t.responseType.toLowerCase();
                                    n.responseType = "json" !== e ? e : "text";
                                }
                                const r = t.serializeBody();
                                let s = null;
                                const i = () => {
                                        if (null !== s) return s;
                                        const e =
                                                1223 === n.status
                                                    ? 204
                                                    : n.status,
                                            r = n.statusText || "OK",
                                            i = new Fu(
                                                n.getAllResponseHeaders()
                                            ),
                                            o =
                                                (function (t) {
                                                    return "responseURL" in t &&
                                                        t.responseURL
                                                        ? t.responseURL
                                                        : /^X-Request-URL:/m.test(
                                                              t.getAllResponseHeaders()
                                                          )
                                                        ? t.getResponseHeader(
                                                              "X-Request-URL"
                                                          )
                                                        : null;
                                                })(n) || t.url;
                                        return (
                                            (s = new Zu({
                                                headers: i,
                                                status: e,
                                                statusText: r,
                                                url: o,
                                            })),
                                            s
                                        );
                                    },
                                    o = () => {
                                        let {
                                                headers: r,
                                                status: s,
                                                statusText: o,
                                                url: a,
                                            } = i(),
                                            l = null;
                                        204 !== s &&
                                            (l =
                                                void 0 === n.response
                                                    ? n.responseText
                                                    : n.response),
                                            0 === s && (s = l ? 200 : 0);
                                        let c = s >= 200 && s < 300;
                                        if (
                                            "json" === t.responseType &&
                                            "string" == typeof l
                                        ) {
                                            const t = l;
                                            l = l.replace(eh, "");
                                            try {
                                                l =
                                                    "" !== l
                                                        ? JSON.parse(l)
                                                        : null;
                                            } catch (u) {
                                                (l = t),
                                                    c &&
                                                        ((c = !1),
                                                        (l = {
                                                            error: u,
                                                            text: l,
                                                        }));
                                            }
                                        }
                                        c
                                            ? (e.next(
                                                  new Yu({
                                                      body: l,
                                                      headers: r,
                                                      status: s,
                                                      statusText: o,
                                                      url: a || void 0,
                                                  })
                                              ),
                                              e.complete())
                                            : e.error(
                                                  new Gu({
                                                      error: l,
                                                      headers: r,
                                                      status: s,
                                                      statusText: o,
                                                      url: a || void 0,
                                                  })
                                              );
                                    },
                                    a = (t) => {
                                        const { url: r } = i(),
                                            s = new Gu({
                                                error: t,
                                                status: n.status || 0,
                                                statusText:
                                                    n.statusText ||
                                                    "Unknown Error",
                                                url: r || void 0,
                                            });
                                        e.error(s);
                                    };
                                let l = !1;
                                const c = (r) => {
                                        l || (e.next(i()), (l = !0));
                                        let s = {
                                            type: Wu.DownloadProgress,
                                            loaded: r.loaded,
                                        };
                                        r.lengthComputable &&
                                            (s.total = r.total),
                                            "text" === t.responseType &&
                                                n.responseText &&
                                                (s.partialText =
                                                    n.responseText),
                                            e.next(s);
                                    },
                                    u = (t) => {
                                        let n = {
                                            type: Wu.UploadProgress,
                                            loaded: t.loaded,
                                        };
                                        t.lengthComputable &&
                                            (n.total = t.total),
                                            e.next(n);
                                    };
                                return (
                                    n.addEventListener("load", o),
                                    n.addEventListener("error", a),
                                    t.reportProgress &&
                                        (n.addEventListener("progress", c),
                                        null !== r &&
                                            n.upload &&
                                            n.upload.addEventListener(
                                                "progress",
                                                u
                                            )),
                                    n.send(r),
                                    e.next({ type: Wu.Sent }),
                                    () => {
                                        n.removeEventListener("error", a),
                                            n.removeEventListener("load", o),
                                            t.reportProgress &&
                                                (n.removeEventListener(
                                                    "progress",
                                                    c
                                                ),
                                                null !== r &&
                                                    n.upload &&
                                                    n.upload.removeEventListener(
                                                        "progress",
                                                        u
                                                    )),
                                            n.readyState !== n.DONE &&
                                                n.abort();
                                    }
                                );
                            });
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(nh));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })();
            const ih = new Nn("XSRF_COOKIE_NAME"),
                oh = new Nn("XSRF_HEADER_NAME");
            class ah {}
            let lh = (() => {
                    class t {
                        constructor(t, e, n) {
                            (this.doc = t),
                                (this.platform = e),
                                (this.cookieName = n),
                                (this.lastCookieString = ""),
                                (this.lastToken = null),
                                (this.parseCount = 0);
                        }
                        getToken() {
                            if ("server" === this.platform) return null;
                            const t = this.doc.cookie || "";
                            return (
                                t !== this.lastCookieString &&
                                    (this.parseCount++,
                                    (this.lastToken = Zc(t, this.cookieName)),
                                    (this.lastCookieString = t)),
                                this.lastToken
                            );
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(qc), sr(ec), sr(ih));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                ch = (() => {
                    class t {
                        constructor(t, e) {
                            (this.tokenService = t), (this.headerName = e);
                        }
                        intercept(t, e) {
                            const n = t.url.toLowerCase();
                            if (
                                "GET" === t.method ||
                                "HEAD" === t.method ||
                                n.startsWith("http://") ||
                                n.startsWith("https://")
                            )
                                return e.handle(t);
                            const r = this.tokenService.getToken();
                            return (
                                null === r ||
                                    t.headers.has(this.headerName) ||
                                    (t = t.clone({
                                        headers: t.headers.set(
                                            this.headerName,
                                            r
                                        ),
                                    })),
                                e.handle(t)
                            );
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(ah), sr(oh));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                uh = (() => {
                    class t {
                        constructor(t, e) {
                            (this.backend = t),
                                (this.injector = e),
                                (this.chain = null);
                        }
                        handle(t) {
                            if (null === this.chain) {
                                const t = this.injector.get($u, []);
                                this.chain = t.reduceRight(
                                    (t, e) => new Qu(t, e),
                                    this.backend
                                );
                            }
                            return this.chain.handle(t);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(sr(Vu), sr(Ji));
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                hh = (() => {
                    class t {
                        static disable() {
                            return {
                                ngModule: t,
                                providers: [{ provide: ch, useClass: th }],
                            };
                        }
                        static withOptions(e = {}) {
                            return {
                                ngModule: t,
                                providers: [
                                    e.cookieName
                                        ? {
                                              provide: ih,
                                              useValue: e.cookieName,
                                          }
                                        : [],
                                    e.headerName
                                        ? {
                                              provide: oh,
                                              useValue: e.headerName,
                                          }
                                        : [],
                                ],
                            };
                        }
                    }
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)();
                            },
                            providers: [
                                ch,
                                { provide: $u, useExisting: ch, multi: !0 },
                                { provide: ah, useClass: lh },
                                { provide: ih, useValue: "XSRF-TOKEN" },
                                { provide: oh, useValue: "X-XSRF-TOKEN" },
                            ],
                        })),
                        t
                    );
                })(),
                dh = (() => {
                    class t {}
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)();
                            },
                            providers: [
                                Ju,
                                { provide: Du, useClass: uh },
                                sh,
                                { provide: Vu, useExisting: sh },
                                rh,
                                { provide: nh, useExisting: rh },
                            ],
                            imports: [
                                [
                                    hh.withOptions({
                                        cookieName: "XSRF-TOKEN",
                                        headerName: "X-XSRF-TOKEN",
                                    }),
                                ],
                            ],
                        })),
                        t
                    );
                })();
            class ph extends h {
                constructor(t, e) {
                    super();
                }
                schedule(t, e = 0) {
                    return this;
                }
            }
            class fh extends ph {
                constructor(t, e) {
                    super(t, e),
                        (this.scheduler = t),
                        (this.work = e),
                        (this.pending = !1);
                }
                schedule(t, e = 0) {
                    if (this.closed) return this;
                    this.state = t;
                    const n = this.id,
                        r = this.scheduler;
                    return (
                        null != n && (this.id = this.recycleAsyncId(r, n, e)),
                        (this.pending = !0),
                        (this.delay = e),
                        (this.id =
                            this.id || this.requestAsyncId(r, this.id, e)),
                        this
                    );
                }
                requestAsyncId(t, e, n = 0) {
                    return setInterval(t.flush.bind(t, this), n);
                }
                recycleAsyncId(t, e, n = 0) {
                    if (null !== n && this.delay === n && !1 === this.pending)
                        return e;
                    clearInterval(e);
                }
                execute(t, e) {
                    if (this.closed)
                        return new Error("executing a cancelled action");
                    this.pending = !1;
                    const n = this._execute(t, e);
                    if (n) return n;
                    !1 === this.pending &&
                        null != this.id &&
                        (this.id = this.recycleAsyncId(
                            this.scheduler,
                            this.id,
                            null
                        ));
                }
                _execute(t, e) {
                    let n,
                        r = !1;
                    try {
                        this.work(t);
                    } catch (s) {
                        (r = !0), (n = (!!s && s) || new Error(s));
                    }
                    if (r) return this.unsubscribe(), n;
                }
                _unsubscribe() {
                    const t = this.id,
                        e = this.scheduler,
                        n = e.actions,
                        r = n.indexOf(this);
                    (this.work = null),
                        (this.state = null),
                        (this.pending = !1),
                        (this.scheduler = null),
                        -1 !== r && n.splice(r, 1),
                        null != t &&
                            (this.id = this.recycleAsyncId(e, t, null)),
                        (this.delay = null);
                }
            }
            class gh extends fh {
                constructor(t, e) {
                    super(t, e), (this.scheduler = t), (this.work = e);
                }
                schedule(t, e = 0) {
                    return e > 0
                        ? super.schedule(t, e)
                        : ((this.delay = e),
                          (this.state = t),
                          this.scheduler.flush(this),
                          this);
                }
                execute(t, e) {
                    return e > 0 || this.closed
                        ? super.execute(t, e)
                        : this._execute(t, e);
                }
                requestAsyncId(t, e, n = 0) {
                    return (null !== n && n > 0) ||
                        (null === n && this.delay > 0)
                        ? super.requestAsyncId(t, e, n)
                        : t.flush(this);
                }
            }
            let mh = (() => {
                class t {
                    constructor(e, n = t.now) {
                        (this.SchedulerAction = e), (this.now = n);
                    }
                    schedule(t, e = 0, n) {
                        return new this.SchedulerAction(this, t).schedule(n, e);
                    }
                }
                return (t.now = () => Date.now()), t;
            })();
            class yh extends mh {
                constructor(t, e = mh.now) {
                    super(t, () =>
                        yh.delegate && yh.delegate !== this
                            ? yh.delegate.now()
                            : e()
                    ),
                        (this.actions = []),
                        (this.active = !1),
                        (this.scheduled = void 0);
                }
                schedule(t, e = 0, n) {
                    return yh.delegate && yh.delegate !== this
                        ? yh.delegate.schedule(t, e, n)
                        : super.schedule(t, e, n);
                }
                flush(t) {
                    const { actions: e } = this;
                    if (this.active) return void e.push(t);
                    let n;
                    this.active = !0;
                    do {
                        if ((n = t.execute(t.state, t.delay))) break;
                    } while ((t = e.shift()));
                    if (((this.active = !1), n)) {
                        for (; (t = e.shift()); ) t.unsubscribe();
                        throw n;
                    }
                }
            }
            class vh extends yh {}
            const bh = new vh(gh),
                wh = new v((t) => t.complete());
            let Ch = (() => {
                class t {
                    constructor(t, e, n) {
                        (this.kind = t),
                            (this.value = e),
                            (this.error = n),
                            (this.hasValue = "N" === t);
                    }
                    observe(t) {
                        switch (this.kind) {
                            case "N":
                                return t.next && t.next(this.value);
                            case "E":
                                return t.error && t.error(this.error);
                            case "C":
                                return t.complete && t.complete();
                        }
                    }
                    do(t, e, n) {
                        switch (this.kind) {
                            case "N":
                                return t && t(this.value);
                            case "E":
                                return e && e(this.error);
                            case "C":
                                return n && n();
                        }
                    }
                    accept(t, e, n) {
                        return t && "function" == typeof t.next
                            ? this.observe(t)
                            : this.do(t, e, n);
                    }
                    toObservable() {
                        switch (this.kind) {
                            case "N":
                                return Pu(this.value);
                            case "E":
                                return (
                                    (t = this.error), new v((e) => e.error(t))
                                );
                            case "C":
                                return wh;
                        }
                        var t;
                        throw new Error("unexpected notification kind value");
                    }
                    static createNext(e) {
                        return void 0 !== e
                            ? new t("N", e)
                            : t.undefinedValueNotification;
                    }
                    static createError(e) {
                        return new t("E", void 0, e);
                    }
                    static createComplete() {
                        return t.completeNotification;
                    }
                }
                return (
                    (t.completeNotification = new t("C")),
                    (t.undefinedValueNotification = new t("N", void 0)),
                    t
                );
            })();
            class xh extends f {
                constructor(t, e, n = 0) {
                    super(t), (this.scheduler = e), (this.delay = n);
                }
                static dispatch(t) {
                    const { notification: e, destination: n } = t;
                    e.observe(n), this.unsubscribe();
                }
                scheduleMessage(t) {
                    this.destination.add(
                        this.scheduler.schedule(
                            xh.dispatch,
                            this.delay,
                            new _h(t, this.destination)
                        )
                    );
                }
                _next(t) {
                    this.scheduleMessage(Ch.createNext(t));
                }
                _error(t) {
                    this.scheduleMessage(Ch.createError(t)), this.unsubscribe();
                }
                _complete() {
                    this.scheduleMessage(Ch.createComplete()),
                        this.unsubscribe();
                }
            }
            class _h {
                constructor(t, e) {
                    (this.notification = t), (this.destination = e);
                }
            }
            class kh extends _ {
                constructor(
                    t = Number.POSITIVE_INFINITY,
                    e = Number.POSITIVE_INFINITY,
                    n
                ) {
                    super(),
                        (this.scheduler = n),
                        (this._events = []),
                        (this._infiniteTimeWindow = !1),
                        (this._bufferSize = t < 1 ? 1 : t),
                        (this._windowTime = e < 1 ? 1 : e),
                        e === Number.POSITIVE_INFINITY
                            ? ((this._infiniteTimeWindow = !0),
                              (this.next = this.nextInfiniteTimeWindow))
                            : (this.next = this.nextTimeWindow);
                }
                nextInfiniteTimeWindow(t) {
                    if (!this.isStopped) {
                        const e = this._events;
                        e.push(t), e.length > this._bufferSize && e.shift();
                    }
                    super.next(t);
                }
                nextTimeWindow(t) {
                    this.isStopped ||
                        (this._events.push(new Ah(this._getNow(), t)),
                        this._trimBufferThenGetEvents()),
                        super.next(t);
                }
                _subscribe(t) {
                    const e = this._infiniteTimeWindow,
                        n = e ? this._events : this._trimBufferThenGetEvents(),
                        r = this.scheduler,
                        s = n.length;
                    let i;
                    if (this.closed) throw new w();
                    if (
                        (this.isStopped || this.hasError
                            ? (i = h.EMPTY)
                            : (this.observers.push(t), (i = new C(this, t))),
                        r && t.add((t = new xh(t, r))),
                        e)
                    )
                        for (let o = 0; o < s && !t.closed; o++) t.next(n[o]);
                    else
                        for (let o = 0; o < s && !t.closed; o++)
                            t.next(n[o].value);
                    return (
                        this.hasError
                            ? t.error(this.thrownError)
                            : this.isStopped && t.complete(),
                        i
                    );
                }
                _getNow() {
                    return (this.scheduler || bh).now();
                }
                _trimBufferThenGetEvents() {
                    const t = this._getNow(),
                        e = this._bufferSize,
                        n = this._windowTime,
                        r = this._events,
                        s = r.length;
                    let i = 0;
                    for (; i < s && !(t - r[i].time < n); ) i++;
                    return (
                        s > e && (i = Math.max(i, s - e)),
                        i > 0 && r.splice(0, i),
                        r
                    );
                }
            }
            class Ah {
                constructor(t, e) {
                    (this.time = t), (this.value = e);
                }
            }
            function Eh(t, e) {
                return "function" == typeof e
                    ? (n) =>
                          n.pipe(
                              Eh((n, r) =>
                                  V(t(n, r)).pipe(E((t, s) => e(n, t, r, s)))
                              )
                          )
                    : (e) => e.lift(new Ih(t));
            }
            class Ih {
                constructor(t) {
                    this.project = t;
                }
                call(t, e) {
                    return e.subscribe(new Th(t, this.project));
                }
            }
            class Th extends j {
                constructor(t, e) {
                    super(t), (this.project = e), (this.index = 0);
                }
                _next(t) {
                    let e;
                    const n = this.index++;
                    try {
                        e = this.project(t, n);
                    } catch (r) {
                        return void this.destination.error(r);
                    }
                    this._innerSub(e);
                }
                _innerSub(t) {
                    const e = this.innerSubscription;
                    e && e.unsubscribe();
                    const n = new F(this),
                        r = this.destination;
                    r.add(n),
                        (this.innerSubscription = z(t, n)),
                        this.innerSubscription !== n &&
                            r.add(this.innerSubscription);
                }
                _complete() {
                    const { innerSubscription: t } = this;
                    (t && !t.closed) || super._complete(), this.unsubscribe();
                }
                _unsubscribe() {
                    this.innerSubscription = void 0;
                }
                notifyComplete() {
                    (this.innerSubscription = void 0),
                        this.isStopped && super._complete();
                }
                notifyNext(t) {
                    this.destination.next(t);
                }
            }
            const Sh = {
                schedule(t, e) {
                    const n = setTimeout(t, e);
                    return () => clearTimeout(n);
                },
                scheduleBeforeRender(t) {
                    if ("undefined" == typeof window) return Sh.schedule(t, 0);
                    if (void 0 === window.requestAnimationFrame)
                        return Sh.schedule(t, 16);
                    const e = window.requestAnimationFrame(t);
                    return () => window.cancelAnimationFrame(e);
                },
            };
            let Oh;
            function Mh(t, e, n) {
                let r = n;
                return (
                    (function (t) {
                        return !!t && t.nodeType === Node.ELEMENT_NODE;
                    })(t) &&
                        e.some(
                            (e, n) =>
                                !(
                                    "*" === e ||
                                    !(function (t, e) {
                                        if (!Oh) {
                                            const t = Element.prototype;
                                            Oh =
                                                t.matches ||
                                                t.matchesSelector ||
                                                t.mozMatchesSelector ||
                                                t.msMatchesSelector ||
                                                t.oMatchesSelector ||
                                                t.webkitMatchesSelector;
                                        }
                                        return (
                                            t.nodeType === Node.ELEMENT_NODE &&
                                            Oh.call(t, e)
                                        );
                                    })(t, e) ||
                                    ((r = n), 0)
                                )
                        ),
                    r
                );
            }
            class Ph {
                constructor(t, e) {
                    this.componentFactory = e
                        .get(Ia)
                        .resolveComponentFactory(t);
                }
                create(t) {
                    return new Rh(this.componentFactory, t);
                }
            }
            class Rh {
                constructor(t, e) {
                    (this.componentFactory = t),
                        (this.injector = e),
                        (this.eventEmitters = new kh(1)),
                        (this.events = this.eventEmitters.pipe(
                            Eh((t) => K(...t))
                        )),
                        (this.componentRef = null),
                        (this.viewChangeDetectorRef = null),
                        (this.inputChanges = null),
                        (this.hasInputChanges = !1),
                        (this.implementsOnChanges = !1),
                        (this.scheduledChangeDetectionFn = null),
                        (this.scheduledDestroyFn = null),
                        (this.initialInputValues = new Map()),
                        (this.unchangedInputs = new Set(
                            this.componentFactory.inputs.map(
                                ({ propName: t }) => t
                            )
                        )),
                        (this.ngZone = this.injector.get(mc)),
                        (this.elementZone =
                            "undefined" == typeof Zone
                                ? null
                                : this.ngZone.run(() => Zone.current));
                }
                connect(t) {
                    this.runInZone(() => {
                        if (null !== this.scheduledDestroyFn)
                            return (
                                this.scheduledDestroyFn(),
                                void (this.scheduledDestroyFn = null)
                            );
                        null === this.componentRef &&
                            this.initializeComponent(t);
                    });
                }
                disconnect() {
                    this.runInZone(() => {
                        null !== this.componentRef &&
                            null === this.scheduledDestroyFn &&
                            (this.scheduledDestroyFn = Sh.schedule(() => {
                                null !== this.componentRef &&
                                    (this.componentRef.destroy(),
                                    (this.componentRef = null),
                                    (this.viewChangeDetectorRef = null));
                            }, 10));
                    });
                }
                getInputValue(t) {
                    return this.runInZone(() =>
                        null === this.componentRef
                            ? this.initialInputValues.get(t)
                            : this.componentRef.instance[t]
                    );
                }
                setInputValue(t, e) {
                    this.runInZone(() => {
                        var n, r;
                        null !== this.componentRef
                            ? (((n = e) !== (r = this.getInputValue(t)) &&
                                  (n == n || r == r)) ||
                                  (void 0 === e &&
                                      this.unchangedInputs.has(t))) &&
                              (this.recordInputChange(t, e),
                              this.unchangedInputs.delete(t),
                              (this.hasInputChanges = !0),
                              (this.componentRef.instance[t] = e),
                              this.scheduleDetectChanges())
                            : this.initialInputValues.set(t, e);
                    });
                }
                initializeComponent(t) {
                    const e = Ji.create({
                            providers: [],
                            parent: this.injector,
                        }),
                        n = (function (t, e) {
                            const n = t.childNodes,
                                r = e.map(() => []);
                            let s = -1;
                            e.some((t, e) => "*" === t && ((s = e), !0));
                            for (let i = 0, o = n.length; i < o; ++i) {
                                const t = n[i],
                                    o = Mh(t, e, s);
                                -1 !== o && r[o].push(t);
                            }
                            return r;
                        })(t, this.componentFactory.ngContentSelectors);
                    (this.componentRef = this.componentFactory.create(e, n, t)),
                        (this.viewChangeDetectorRef =
                            this.componentRef.injector.get(rl)),
                        (this.implementsOnChanges =
                            "function" ==
                            typeof this.componentRef.instance.ngOnChanges),
                        this.initializeInputs(),
                        this.initializeOutputs(this.componentRef),
                        this.detectChanges(),
                        this.injector
                            .get(Vc)
                            .attachView(this.componentRef.hostView);
                }
                initializeInputs() {
                    this.componentFactory.inputs.forEach(({ propName: t }) => {
                        this.initialInputValues.has(t) &&
                            this.setInputValue(
                                t,
                                this.initialInputValues.get(t)
                            );
                    }),
                        this.initialInputValues.clear();
                }
                initializeOutputs(t) {
                    const e = this.componentFactory.outputs.map(
                        ({ propName: e, templateName: n }) =>
                            t.instance[e].pipe(
                                E((t) => ({ name: n, value: t }))
                            )
                    );
                    this.eventEmitters.next(e);
                }
                callNgOnChanges(t) {
                    if (!this.implementsOnChanges || null === this.inputChanges)
                        return;
                    const e = this.inputChanges;
                    (this.inputChanges = null), t.instance.ngOnChanges(e);
                }
                markViewForCheck(t) {
                    this.hasInputChanges &&
                        ((this.hasInputChanges = !1), t.markForCheck());
                }
                scheduleDetectChanges() {
                    this.scheduledChangeDetectionFn ||
                        (this.scheduledChangeDetectionFn =
                            Sh.scheduleBeforeRender(() => {
                                (this.scheduledChangeDetectionFn = null),
                                    this.detectChanges();
                            }));
                }
                recordInputChange(t, e) {
                    if (!this.implementsOnChanges) return;
                    null === this.inputChanges && (this.inputChanges = {});
                    const n = this.inputChanges[t];
                    if (n) return void (n.currentValue = e);
                    const r = this.unchangedInputs.has(t),
                        s = r ? void 0 : this.getInputValue(t);
                    this.inputChanges[t] = new ee(s, e, r);
                }
                detectChanges() {
                    null !== this.componentRef &&
                        (this.callNgOnChanges(this.componentRef),
                        this.markViewForCheck(this.viewChangeDetectorRef),
                        this.componentRef.changeDetectorRef.detectChanges());
                }
                runInZone(t) {
                    return this.elementZone && Zone.current !== this.elementZone
                        ? this.ngZone.run(t)
                        : t();
                }
            }
            class Nh extends HTMLElement {
                constructor() {
                    super(...arguments),
                        (this.ngElementEventsSubscription = null);
                }
            }
            new Fa("11.1.2");
            const Dh = new _();
            let Vh = (() => {
                class t {
                    constructor(t) {
                        this.http = t;
                    }
                    get appended$() {
                        return Dh.asObservable();
                    }
                    updateColorsOverrides(t) {
                        this.http
                            .post(
                                "https://assassin.startbootstrap.com/api/latest/compile",
                                t
                            )
                            .subscribe((t) => {
                                this._addStyle(t.css), Dh.next(!0);
                            });
                    }
                    generateVariableOverridesFile(t) {
                        let e = `${(function (t) {
                            switch (t) {
                                case "material-admin-pro":
                                    return "// This file was generated for Start Bootstrap Material Admin Pro\n// https://startbootstrap.com/theme/material-admin-pro\n// Place this file in src/scss/_variables-colors-overrides.scss\n\n";
                                case "sb-admin-pro":
                                    return "// This file was generated for Start Bootstrap Admin Pro\n// https://startbootstrap.com/theme/sb-admin-pro\n// Place this file in src/scss/_variables-colors-overrides.scss\n\n";
                                case "sb-admin-pro-angular":
                                    return "// This file was generated for Start Bootstrap Admin Pro Angular\n// https://startbootstrap.com/theme/sb-admin-pro-angular\n// Place this file in src/styles/sb-admin-pro/_variables-colors-overrides.scss\n\n";
                                case "sb-ui-kit-pro":
                                    return "// This file was generated for Start Bootstrap UI Kit Pro\n// https://startbootstrap.com/theme/sb-ui-kit-pro\n// Place this file in src/scss/_variables-colors-overrides.scss\n\n";
                                case "sb-ui-kit-pro-angular":
                                    return "// This file was generated for Start Bootstrap UI Kit Pro Angular\n// https://startbootstrap.com/theme/sb-ui-kit-pro-angular\n// Place this file in src/styles/sb-ui-kit-pro/_variables-colors-overrides.scss\n\n";
                            }
                            return "";
                        })(t.theme)}`;
                        for (const n in t.colors)
                            t.colors[n] && (e += `$${n}: ${t.colors[n]};\n`);
                        return e;
                    }
                    _addStyle(t) {
                        const e = document.getElementById("StyleGenerator");
                        e && e.parentNode && e.parentNode.removeChild(e);
                        const n =
                                document.head ||
                                document.getElementsByTagName("head")[0],
                            r = document.createElement("style");
                        r.setAttribute("id", "StyleGenerator"),
                            n.appendChild(r),
                            r.appendChild(document.createTextNode(t));
                    }
                }
                return (
                    (t.ɵfac = function (e) {
                        return new (e || t)(sr(Ju));
                    }),
                    (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                    t
                );
            })();
            var Fh = {
                    prefix: "fas",
                    iconName: "check",
                    icon: [
                        512,
                        512,
                        [],
                        "f00c",
                        "M173.898 439.404l-166.4-166.4c-9.997-9.997-9.997-26.206 0-36.204l36.203-36.204c9.997-9.998 26.207-9.998 36.204 0L192 312.69 432.095 72.596c9.997-9.997 26.207-9.997 36.204 0l36.203 36.204c9.997 9.997 9.997 26.206 0 36.204l-294.4 294.401c-9.998 9.997-26.207 9.997-36.204-.001z",
                    ],
                },
                jh = {
                    prefix: "fas",
                    iconName: "cog",
                    icon: [
                        512,
                        512,
                        [],
                        "f013",
                        "M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z",
                    ],
                },
                zh = {
                    prefix: "fas",
                    iconName: "file-download",
                    icon: [
                        384,
                        512,
                        [],
                        "f56d",
                        "M224 136V0H24C10.7 0 0 10.7 0 24v464c0 13.3 10.7 24 24 24h336c13.3 0 24-10.7 24-24V160H248c-13.2 0-24-10.8-24-24zm76.45 211.36l-96.42 95.7c-6.65 6.61-17.39 6.61-24.04 0l-96.42-95.7C73.42 337.29 80.54 320 94.82 320H160v-80c0-8.84 7.16-16 16-16h32c8.84 0 16 7.16 16 16v80h65.18c14.28 0 21.4 17.29 11.27 27.36zM377 105L279.1 7c-4.5-4.5-10.6-7-17-7H256v128h128v-6.1c0-6.3-2.5-12.4-7-16.9z",
                    ],
                },
                Bh = {
                    prefix: "fas",
                    iconName: "random",
                    icon: [
                        512,
                        512,
                        [],
                        "f074",
                        "M504.971 359.029c9.373 9.373 9.373 24.569 0 33.941l-80 79.984c-15.01 15.01-40.971 4.49-40.971-16.971V416h-58.785a12.004 12.004 0 0 1-8.773-3.812l-70.556-75.596 53.333-57.143L352 336h32v-39.981c0-21.438 25.943-31.998 40.971-16.971l80 79.981zM12 176h84l52.781 56.551 53.333-57.143-70.556-75.596A11.999 11.999 0 0 0 122.785 96H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12zm372 0v39.984c0 21.46 25.961 31.98 40.971 16.971l80-79.984c9.373-9.373 9.373-24.569 0-33.941l-80-79.981C409.943 24.021 384 34.582 384 56.019V96h-58.785a12.004 12.004 0 0 0-8.773 3.812L96 336H12c-6.627 0-12 5.373-12 12v56c0 6.627 5.373 12 12 12h110.785c3.326 0 6.503-1.381 8.773-3.812L352 176h32z",
                    ],
                },
                Hh = n("1Hq2"),
                Lh = n.n(Hh),
                qh = n("/CYg"),
                Kh = n.n(qh),
                Wh = n("sEfC"),
                Uh = n.n(Wh);
            const Zh = [
                    { id: "primary", name: "Primary", class: "btn-primary" },
                    {
                        id: "secondary",
                        name: "Secondary",
                        class: "btn-secondary",
                    },
                    { id: "success", name: "Success", class: "btn-success" },
                    { id: "danger", name: "Danger", class: "btn-danger" },
                    { id: "warning", name: "Warning", class: "btn-warning" },
                    { id: "info", name: "Info", class: "btn-info" },
                ],
                Yh = [
                    {
                        id: "swatch1",
                        name: "Default",
                        colors: {
                            primary: "#0061f2",
                            secondary: "#6900c7",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "swatch2",
                        name: "Flat",
                        colors: {
                            primary: "#1da1f5",
                            secondary: "#8039da",
                            success: "#12ac70",
                            danger: "#e83d2c",
                            warning: "#ffc147",
                            info: "#2ccfd4",
                        },
                    },
                    {
                        id: "swatch3",
                        name: "Sunset",
                        colors: {
                            primary: "#f53b57",
                            secondary: "#ff793f",
                            success: "#05c46b",
                            danger: "#dd433a",
                            warning: "#ffa801",
                            info: "#575fcf",
                        },
                    },
                    {
                        id: "swatch4",
                        name: "Subtle",
                        colors: {
                            primary: "#6eabc2",
                            secondary: "#506c6a",
                            success: "#799f78",
                            danger: "#bb8282",
                            warning: "#d5c357",
                            info: "#957fa9",
                        },
                    },
                    {
                        id: "swatch5",
                        name: "Seafoam",
                        colors: {
                            primary: "#06794f",
                            secondary: "#0fa28b",
                            success: "#3ac97c",
                            danger: "#d73f30",
                            warning: "#ebb20c",
                            info: "#9d46cd",
                        },
                    },
                ],
                Gh = [
                    {
                        id: "freelancerDefault",
                        name: "Default",
                        colors: {
                            primary: "#1abc9c",
                            secondary: "#2c3e50",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerBlues",
                        name: "Blues",
                        colors: {
                            primary: "#9cc3d5",
                            secondary: "#0063b2",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerBluePurple",
                        name: "Blue Purple",
                        colors: {
                            primary: "#0061f2",
                            secondary: "#6900c7",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerPinkOrange",
                        name: "Pink Orange",
                        colors: {
                            primary: "#e30059",
                            secondary: "#f76400",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerDarkCyan",
                        name: "Dark Cyan",
                        colors: {
                            primary: "#1f2d41",
                            secondary: "#00cfd5",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerRedYellow",
                        name: "Red Yellow",
                        colors: {
                            primary: "#A13941",
                            secondary: "#e7b633",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerTanMaroon",
                        name: "Tan Maroon",
                        colors: {
                            primary: "#c2af89",
                            secondary: "#343148",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerYellowPurple",
                        name: "Yellow Purple",
                        colors: {
                            primary: "#f4a100",
                            secondary: "#6900c7",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerMangoMoss",
                        name: "Mango Moss",
                        colors: {
                            primary: "#DAA03D",
                            secondary: "#616247",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                    {
                        id: "freelancerCoralBlue",
                        name: "Coral Blue",
                        colors: {
                            primary: "#fc766a",
                            secondary: "#5b84b1",
                            success: "#00ac69",
                            danger: "#e81500",
                            warning: "#f4a100",
                            info: "#00cfd5",
                        },
                    },
                ];
            function Xh(t) {
                return (Xh =
                    "function" == typeof Symbol &&
                    "symbol" == typeof Symbol.iterator
                        ? function (t) {
                              return typeof t;
                          }
                        : function (t) {
                              return t &&
                                  "function" == typeof Symbol &&
                                  t.constructor === Symbol &&
                                  t !== Symbol.prototype
                                  ? "symbol"
                                  : typeof t;
                          })(t);
            }
            function Jh(t, e, n) {
                return (
                    e in t
                        ? Object.defineProperty(t, e, {
                              value: n,
                              enumerable: !0,
                              configurable: !0,
                              writable: !0,
                          })
                        : (t[e] = n),
                    t
                );
            }
            function Qh(t) {
                for (var e = 1; e < arguments.length; e++) {
                    var n = null != arguments[e] ? arguments[e] : {},
                        r = Object.keys(n);
                    "function" == typeof Object.getOwnPropertySymbols &&
                        (r = r.concat(
                            Object.getOwnPropertySymbols(n).filter(function (
                                t
                            ) {
                                return Object.getOwnPropertyDescriptor(n, t)
                                    .enumerable;
                            })
                        )),
                        r.forEach(function (e) {
                            Jh(t, e, n[e]);
                        });
                }
                return t;
            }
            function $h(t, e) {
                return (
                    (function (t) {
                        if (Array.isArray(t)) return t;
                    })(t) ||
                    (function (t, e) {
                        var n = [],
                            r = !0,
                            s = !1,
                            i = void 0;
                        try {
                            for (
                                var o, a = t[Symbol.iterator]();
                                !(r = (o = a.next()).done) &&
                                (n.push(o.value), !e || n.length !== e);
                                r = !0
                            );
                        } catch (l) {
                            (s = !0), (i = l);
                        } finally {
                            try {
                                r || null == a.return || a.return();
                            } finally {
                                if (s) throw i;
                            }
                        }
                        return n;
                    })(t, e) ||
                    (function () {
                        throw new TypeError(
                            "Invalid attempt to destructure non-iterable instance"
                        );
                    })()
                );
            }
            var td = {},
                ed = {};
            try {
                "undefined" != typeof window && (td = window),
                    "undefined" != typeof document && (ed = document),
                    "undefined" != typeof MutationObserver && MutationObserver,
                    "undefined" != typeof performance && performance;
            } catch (_f) {}
            var nd = (td.navigator || {}).userAgent,
                rd = void 0 === nd ? "" : nd,
                sd = td,
                id = ed,
                od =
                    !!id.documentElement &&
                    !!id.head &&
                    "function" == typeof id.addEventListener &&
                    "function" == typeof id.createElement,
                ad =
                    (~rd.indexOf("MSIE") || rd.indexOf("Trident/"),
                    [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
                ld = ad.concat([11, 12, 13, 14, 15, 16, 17, 18, 19, 20]),
                cd = {
                    GROUP: "group",
                    SWAP_OPACITY: "swap-opacity",
                    PRIMARY: "primary",
                    SECONDARY: "secondary",
                },
                ud =
                    ([
                        "xs",
                        "sm",
                        "lg",
                        "fw",
                        "ul",
                        "li",
                        "border",
                        "pull-left",
                        "pull-right",
                        "spin",
                        "pulse",
                        "rotate-90",
                        "rotate-180",
                        "rotate-270",
                        "flip-horizontal",
                        "flip-vertical",
                        "flip-both",
                        "stack",
                        "stack-1x",
                        "stack-2x",
                        "inverse",
                        "layers",
                        "layers-text",
                        "layers-counter",
                        cd.GROUP,
                        cd.SWAP_OPACITY,
                        cd.PRIMARY,
                        cd.SECONDARY,
                    ]
                        .concat(
                            ad.map(function (t) {
                                return "".concat(t, "x");
                            })
                        )
                        .concat(
                            ld.map(function (t) {
                                return "w-".concat(t);
                            })
                        ),
                    sd.FontAwesomeConfig || {});
            id &&
                "function" == typeof id.querySelector &&
                [
                    ["data-family-prefix", "familyPrefix"],
                    ["data-replacement-class", "replacementClass"],
                    ["data-auto-replace-svg", "autoReplaceSvg"],
                    ["data-auto-add-css", "autoAddCss"],
                    ["data-auto-a11y", "autoA11y"],
                    ["data-search-pseudo-elements", "searchPseudoElements"],
                    ["data-observe-mutations", "observeMutations"],
                    ["data-mutate-approach", "mutateApproach"],
                    ["data-keep-original-source", "keepOriginalSource"],
                    ["data-measure-performance", "measurePerformance"],
                    ["data-show-missing-icons", "showMissingIcons"],
                ].forEach(function (t) {
                    var e = $h(t, 2),
                        n = e[1],
                        r = (function (t) {
                            return (
                                "" === t ||
                                ("false" !== t && ("true" === t || t))
                            );
                        })(
                            (function (t) {
                                var e = id.querySelector("script[" + t + "]");
                                if (e) return e.getAttribute(t);
                            })(e[0])
                        );
                    null != r && (ud[n] = r);
                });
            var hd = Qh(
                {},
                {
                    familyPrefix: "fa",
                    replacementClass: "svg-inline--fa",
                    autoReplaceSvg: !0,
                    autoAddCss: !0,
                    autoA11y: !0,
                    searchPseudoElements: !1,
                    observeMutations: !0,
                    mutateApproach: "async",
                    keepOriginalSource: !0,
                    measurePerformance: !1,
                    showMissingIcons: !0,
                },
                ud
            );
            hd.autoReplaceSvg || (hd.observeMutations = !1);
            var dd = Qh({}, hd);
            sd.FontAwesomeConfig = dd;
            var pd = sd || {};
            pd.___FONT_AWESOME___ || (pd.___FONT_AWESOME___ = {}),
                pd.___FONT_AWESOME___.styles ||
                    (pd.___FONT_AWESOME___.styles = {}),
                pd.___FONT_AWESOME___.hooks ||
                    (pd.___FONT_AWESOME___.hooks = {}),
                pd.___FONT_AWESOME___.shims ||
                    (pd.___FONT_AWESOME___.shims = []);
            var fd = pd.___FONT_AWESOME___,
                gd = [];
            od &&
                ((id.documentElement.doScroll
                    ? /^loaded|^c/
                    : /^loaded|^i|^c/
                ).test(id.readyState) ||
                    id.addEventListener("DOMContentLoaded", function t() {
                        id.removeEventListener("DOMContentLoaded", t),
                            gd.map(function (t) {
                                return t();
                            });
                    }));
            var md,
                yd = function () {},
                vd =
                    "undefined" != typeof global &&
                    void 0 !== global.process &&
                    "function" == typeof global.process.emit,
                bd =
                    "undefined" == typeof setImmediate
                        ? setTimeout
                        : setImmediate,
                wd = [];
            function Cd() {
                for (var t = 0; t < wd.length; t++) wd[t][0](wd[t][1]);
                (wd = []), (md = !1);
            }
            function xd(t, e) {
                wd.push([t, e]), md || ((md = !0), bd(Cd, 0));
            }
            function _d(t) {
                var e = t.owner,
                    n = e._state,
                    r = e._data,
                    s = t[n],
                    i = t.then;
                if ("function" == typeof s) {
                    n = "fulfilled";
                    try {
                        r = s(r);
                    } catch (_f) {
                        Id(i, _f);
                    }
                }
                kd(i, r) ||
                    ("fulfilled" === n && Ad(i, r),
                    "rejected" === n && Id(i, r));
            }
            function kd(t, e) {
                var n;
                try {
                    if (t === e)
                        throw new TypeError(
                            "A promises callback cannot return that same promise."
                        );
                    if (e && ("function" == typeof e || "object" === Xh(e))) {
                        var r = e.then;
                        if ("function" == typeof r)
                            return (
                                r.call(
                                    e,
                                    function (r) {
                                        n ||
                                            ((n = !0),
                                            e === r ? Ed(t, r) : Ad(t, r));
                                    },
                                    function (e) {
                                        n || ((n = !0), Id(t, e));
                                    }
                                ),
                                !0
                            );
                    }
                } catch (_f) {
                    return n || Id(t, _f), !0;
                }
                return !1;
            }
            function Ad(t, e) {
                (t !== e && kd(t, e)) || Ed(t, e);
            }
            function Ed(t, e) {
                "pending" === t._state &&
                    ((t._state = "settled"), (t._data = e), xd(Sd, t));
            }
            function Id(t, e) {
                "pending" === t._state &&
                    ((t._state = "settled"), (t._data = e), xd(Od, t));
            }
            function Td(t) {
                t._then = t._then.forEach(_d);
            }
            function Sd(t) {
                (t._state = "fulfilled"), Td(t);
            }
            function Od(t) {
                (t._state = "rejected"),
                    Td(t),
                    !t._handled &&
                        vd &&
                        global.process.emit("unhandledRejection", t._data, t);
            }
            function Md(t) {
                global.process.emit("rejectionHandled", t);
            }
            function Pd(t) {
                if ("function" != typeof t)
                    throw new TypeError(
                        "Promise resolver " + t + " is not a function"
                    );
                if (this instanceof Pd == 0)
                    throw new TypeError(
                        "Failed to construct 'Promise': Please use the 'new' operator, this object constructor cannot be called as a function."
                    );
                (this._then = []),
                    (function (t, e) {
                        function n(t) {
                            Id(e, t);
                        }
                        try {
                            t(function (t) {
                                Ad(e, t);
                            }, n);
                        } catch (_f) {
                            n(_f);
                        }
                    })(t, this);
            }
            (Pd.prototype = {
                constructor: Pd,
                _state: "pending",
                _then: null,
                _data: void 0,
                _handled: !1,
                then: function (t, e) {
                    var n = {
                        owner: this,
                        then: new this.constructor(yd),
                        fulfilled: t,
                        rejected: e,
                    };
                    return (
                        (!e && !t) ||
                            this._handled ||
                            ((this._handled = !0),
                            "rejected" === this._state && vd && xd(Md, this)),
                        "fulfilled" === this._state ||
                        "rejected" === this._state
                            ? xd(_d, n)
                            : this._then.push(n),
                        n.then
                    );
                },
                catch: function (t) {
                    return this.then(null, t);
                },
            }),
                (Pd.all = function (t) {
                    if (!Array.isArray(t))
                        throw new TypeError(
                            "You must pass an array to Promise.all()."
                        );
                    return new Pd(function (e, n) {
                        var r = [],
                            s = 0;
                        function i(t) {
                            return (
                                s++,
                                function (n) {
                                    (r[t] = n), --s || e(r);
                                }
                            );
                        }
                        for (var o, a = 0; a < t.length; a++)
                            (o = t[a]) && "function" == typeof o.then
                                ? o.then(i(a), n)
                                : (r[a] = o);
                        s || e(r);
                    });
                }),
                (Pd.race = function (t) {
                    if (!Array.isArray(t))
                        throw new TypeError(
                            "You must pass an array to Promise.race()."
                        );
                    return new Pd(function (e, n) {
                        for (var r, s = 0; s < t.length; s++)
                            (r = t[s]) && "function" == typeof r.then
                                ? r.then(e, n)
                                : e(r);
                    });
                }),
                (Pd.resolve = function (t) {
                    return t && "object" === Xh(t) && t.constructor === Pd
                        ? t
                        : new Pd(function (e) {
                              e(t);
                          });
                }),
                (Pd.reject = function (t) {
                    return new Pd(function (e, n) {
                        n(t);
                    });
                });
            var Rd = { size: 16, x: 0, y: 0, rotate: 0, flipX: !1, flipY: !1 };
            function Nd() {
                for (var t = 12, e = ""; t-- > 0; )
                    e +=
                        "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"[
                            (62 * Math.random()) | 0
                        ];
                return e;
            }
            function Dd(t) {
                return ""
                    .concat(t)
                    .replace(/&/g, "&amp;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#39;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;");
            }
            function Vd(t) {
                return Object.keys(t || {}).reduce(function (e, n) {
                    return e + "".concat(n, ": ").concat(t[n], ";");
                }, "");
            }
            function Fd(t) {
                return (
                    t.size !== Rd.size ||
                    t.x !== Rd.x ||
                    t.y !== Rd.y ||
                    t.rotate !== Rd.rotate ||
                    t.flipX ||
                    t.flipY
                );
            }
            function jd(t) {
                var e = t.transform,
                    n = t.iconWidth,
                    r = {
                        transform: "translate(".concat(
                            t.containerWidth / 2,
                            " 256)"
                        ),
                    },
                    s = "translate("
                        .concat(32 * e.x, ", ")
                        .concat(32 * e.y, ") "),
                    i = "scale("
                        .concat((e.size / 16) * (e.flipX ? -1 : 1), ", ")
                        .concat((e.size / 16) * (e.flipY ? -1 : 1), ") "),
                    o = "rotate(".concat(e.rotate, " 0 0)");
                return {
                    outer: r,
                    inner: {
                        transform: "".concat(s, " ").concat(i, " ").concat(o),
                    },
                    path: {
                        transform: "translate(".concat((n / 2) * -1, " -256)"),
                    },
                };
            }
            var zd = { x: 0, y: 0, width: "100%", height: "100%" };
            function Bd(t) {
                var e =
                    !(arguments.length > 1 && void 0 !== arguments[1]) ||
                    arguments[1];
                return (
                    t.attributes &&
                        (t.attributes.fill || e) &&
                        (t.attributes.fill = "black"),
                    t
                );
            }
            function Hd(t) {
                var e = t.icons,
                    n = e.main,
                    r = e.mask,
                    s = t.prefix,
                    i = t.iconName,
                    o = t.transform,
                    a = t.symbol,
                    l = t.title,
                    c = t.maskId,
                    u = t.titleId,
                    h = t.extra,
                    d = t.watchable,
                    p = void 0 !== d && d,
                    f = r.found ? r : n,
                    g = f.width,
                    m = f.height,
                    y = "fak" === s,
                    v = y ? "" : "fa-w-".concat(Math.ceil((g / m) * 16)),
                    b = [
                        dd.replacementClass,
                        i ? "".concat(dd.familyPrefix, "-").concat(i) : "",
                        v,
                    ]
                        .filter(function (t) {
                            return -1 === h.classes.indexOf(t);
                        })
                        .filter(function (t) {
                            return "" !== t || !!t;
                        })
                        .concat(h.classes)
                        .join(" "),
                    w = {
                        children: [],
                        attributes: Qh({}, h.attributes, {
                            "data-prefix": s,
                            "data-icon": i,
                            class: b,
                            role: h.attributes.role || "img",
                            xmlns: "http://www.w3.org/2000/svg",
                            viewBox: "0 0 ".concat(g, " ").concat(m),
                        }),
                    },
                    C =
                        y && !~h.classes.indexOf("fa-fw")
                            ? { width: "".concat((g / m) * 16 * 0.0625, "em") }
                            : {};
                p && (w.attributes["data-fa-i2svg"] = ""),
                    l &&
                        w.children.push({
                            tag: "title",
                            attributes: {
                                id:
                                    w.attributes["aria-labelledby"] ||
                                    "title-".concat(u || Nd()),
                            },
                            children: [l],
                        });
                var x = Qh({}, w, {
                        prefix: s,
                        iconName: i,
                        main: n,
                        mask: r,
                        maskId: c,
                        transform: o,
                        symbol: a,
                        styles: Qh({}, C, h.styles),
                    }),
                    _ =
                        r.found && n.found
                            ? (function (t) {
                                  var e,
                                      n = t.children,
                                      r = t.attributes,
                                      s = t.main,
                                      i = t.mask,
                                      o = t.maskId,
                                      a = s.icon,
                                      l = i.icon,
                                      c = jd({
                                          transform: t.transform,
                                          containerWidth: i.width,
                                          iconWidth: s.width,
                                      }),
                                      u = {
                                          tag: "rect",
                                          attributes: Qh({}, zd, {
                                              fill: "white",
                                          }),
                                      },
                                      h = a.children
                                          ? { children: a.children.map(Bd) }
                                          : {},
                                      d = {
                                          tag: "g",
                                          attributes: Qh({}, c.inner),
                                          children: [
                                              Bd(
                                                  Qh(
                                                      {
                                                          tag: a.tag,
                                                          attributes: Qh(
                                                              {},
                                                              a.attributes,
                                                              c.path
                                                          ),
                                                      },
                                                      h
                                                  )
                                              ),
                                          ],
                                      },
                                      p = {
                                          tag: "g",
                                          attributes: Qh({}, c.outer),
                                          children: [d],
                                      },
                                      f = "mask-".concat(o || Nd()),
                                      g = "clip-".concat(o || Nd()),
                                      m = {
                                          tag: "mask",
                                          attributes: Qh({}, zd, {
                                              id: f,
                                              maskUnits: "userSpaceOnUse",
                                              maskContentUnits:
                                                  "userSpaceOnUse",
                                          }),
                                          children: [u, p],
                                      },
                                      y = {
                                          tag: "defs",
                                          children: [
                                              {
                                                  tag: "clipPath",
                                                  attributes: { id: g },
                                                  children:
                                                      ((e = l),
                                                      "g" === e.tag
                                                          ? e.children
                                                          : [e]),
                                              },
                                              m,
                                          ],
                                      };
                                  return (
                                      n.push(y, {
                                          tag: "rect",
                                          attributes: Qh(
                                              {
                                                  fill: "currentColor",
                                                  "clip-path": "url(#".concat(
                                                      g,
                                                      ")"
                                                  ),
                                                  mask: "url(#".concat(f, ")"),
                                              },
                                              zd
                                          ),
                                      }),
                                      { children: n, attributes: r }
                                  );
                              })(x)
                            : (function (t) {
                                  var e = t.children,
                                      n = t.attributes,
                                      r = t.main,
                                      s = t.transform,
                                      i = Vd(t.styles);
                                  if ((i.length > 0 && (n.style = i), Fd(s))) {
                                      var o = jd({
                                          transform: s,
                                          containerWidth: r.width,
                                          iconWidth: r.width,
                                      });
                                      e.push({
                                          tag: "g",
                                          attributes: Qh({}, o.outer),
                                          children: [
                                              {
                                                  tag: "g",
                                                  attributes: Qh({}, o.inner),
                                                  children: [
                                                      {
                                                          tag: r.icon.tag,
                                                          children:
                                                              r.icon.children,
                                                          attributes: Qh(
                                                              {},
                                                              r.icon.attributes,
                                                              o.path
                                                          ),
                                                      },
                                                  ],
                                              },
                                          ],
                                      });
                                  } else e.push(r.icon);
                                  return { children: e, attributes: n };
                              })(x),
                    k = _.attributes;
                return (
                    (x.children = _.children),
                    (x.attributes = k),
                    a
                        ? (function (t) {
                              var e = t.iconName,
                                  n = t.children,
                                  r = t.symbol;
                              return [
                                  {
                                      tag: "svg",
                                      attributes: { style: "display: none;" },
                                      children: [
                                          {
                                              tag: "symbol",
                                              attributes: Qh({}, t.attributes, {
                                                  id:
                                                      !0 === r
                                                          ? ""
                                                                .concat(
                                                                    t.prefix,
                                                                    "-"
                                                                )
                                                                .concat(
                                                                    dd.familyPrefix,
                                                                    "-"
                                                                )
                                                                .concat(e)
                                                          : r,
                                              }),
                                              children: n,
                                          },
                                      ],
                                  },
                              ];
                          })(x)
                        : (function (t) {
                              var e = t.children,
                                  n = t.main,
                                  r = t.mask,
                                  s = t.attributes,
                                  i = t.styles,
                                  o = t.transform;
                              if (Fd(o) && n.found && !r.found) {
                                  var a = { x: n.width / n.height / 2, y: 0.5 };
                                  s.style = Vd(
                                      Qh({}, i, {
                                          "transform-origin": ""
                                              .concat(a.x + o.x / 16, "em ")
                                              .concat(a.y + o.y / 16, "em"),
                                      })
                                  );
                              }
                              return [
                                  { tag: "svg", attributes: s, children: e },
                              ];
                          })(x)
                );
            }
            var Ld = function (t, e, n, r) {
                var s,
                    i,
                    o,
                    a = Object.keys(t),
                    l = a.length,
                    c =
                        void 0 !== r
                            ? (function (t, e) {
                                  return function (n, r, s, i) {
                                      return t.call(e, n, r, s, i);
                                  };
                              })(e, r)
                            : e;
                for (
                    void 0 === n
                        ? ((s = 1), (o = t[a[0]]))
                        : ((s = 0), (o = n));
                    s < l;
                    s++
                )
                    o = c(o, t[(i = a[s])], i, t);
                return o;
            };
            function qd(t, e) {
                var n =
                        arguments.length > 2 && void 0 !== arguments[2]
                            ? arguments[2]
                            : {},
                    r = n.skipHooks,
                    s = void 0 !== r && r,
                    i = Object.keys(e).reduce(function (t, n) {
                        var r = e[n];
                        return (
                            r.icon ? (t[r.iconName] = r.icon) : (t[n] = r), t
                        );
                    }, {});
                "function" != typeof fd.hooks.addPack || s
                    ? (fd.styles[t] = Qh({}, fd.styles[t] || {}, i))
                    : fd.hooks.addPack(t, i),
                    "fas" === t && qd("fa", e);
            }
            var Kd = fd.styles,
                Wd = fd.shims,
                Ud = function () {
                    var t = function (t) {
                        return Ld(
                            Kd,
                            function (e, n, r) {
                                return (e[r] = Ld(n, t, {})), e;
                            },
                            {}
                        );
                    };
                    t(function (t, e, n) {
                        return e[3] && (t[e[3]] = n), t;
                    }),
                        t(function (t, e, n) {
                            var r = e[2];
                            return (
                                (t[n] = n),
                                r.forEach(function (e) {
                                    t[e] = n;
                                }),
                                t
                            );
                        });
                    var e = "far" in Kd;
                    Ld(
                        Wd,
                        function (t, n) {
                            var r = n[1];
                            return (
                                "far" !== r || e || (r = "fas"),
                                (t[n[0]] = { prefix: r, iconName: n[2] }),
                                t
                            );
                        },
                        {}
                    );
                };
            function Zd(t, e, n) {
                if (t && t[e] && t[e][n])
                    return { prefix: e, iconName: n, icon: t[e][n] };
            }
            function Yd(t) {
                var e = t.tag,
                    n = t.attributes,
                    r = void 0 === n ? {} : n,
                    s = t.children,
                    i = void 0 === s ? [] : s;
                return "string" == typeof t
                    ? Dd(t)
                    : "<"
                          .concat(e, " ")
                          .concat(
                              (function (t) {
                                  return Object.keys(t || {})
                                      .reduce(function (e, n) {
                                          return (
                                              e +
                                              ""
                                                  .concat(n, '="')
                                                  .concat(Dd(t[n]), '" ')
                                          );
                                      }, "")
                                      .trim();
                              })(r),
                              ">"
                          )
                          .concat(i.map(Yd).join(""), "</")
                          .concat(e, ">");
            }
            function Gd(t) {
                (this.name = "MissingIcon"),
                    (this.message = t || "Icon unavailable"),
                    (this.stack = new Error().stack);
            }
            Ud(),
                ((Gd.prototype = Object.create(Error.prototype)).constructor =
                    Gd);
            var Xd = { fill: "currentColor" },
                Jd = {
                    attributeType: "XML",
                    repeatCount: "indefinite",
                    dur: "2s",
                },
                Qd =
                    (Qh({}, Xd, {
                        d: "M156.5,447.7l-12.6,29.5c-18.7-9.5-35.9-21.2-51.5-34.9l22.7-22.7C127.6,430.5,141.5,440,156.5,447.7z M40.6,272H8.5 c1.4,21.2,5.4,41.7,11.7,61.1L50,321.2C45.1,305.5,41.8,289,40.6,272z M40.6,240c1.4-18.8,5.2-37,11.1-54.1l-29.5-12.6 C14.7,194.3,10,216.7,8.5,240H40.6z M64.3,156.5c7.8-14.9,17.2-28.8,28.1-41.5L69.7,92.3c-13.7,15.6-25.5,32.8-34.9,51.5 L64.3,156.5z M397,419.6c-13.9,12-29.4,22.3-46.1,30.4l11.9,29.8c20.7-9.9,39.8-22.6,56.9-37.6L397,419.6z M115,92.4 c13.9-12,29.4-22.3,46.1-30.4l-11.9-29.8c-20.7,9.9-39.8,22.6-56.8,37.6L115,92.4z M447.7,355.5c-7.8,14.9-17.2,28.8-28.1,41.5 l22.7,22.7c13.7-15.6,25.5-32.9,34.9-51.5L447.7,355.5z M471.4,272c-1.4,18.8-5.2,37-11.1,54.1l29.5,12.6 c7.5-21.1,12.2-43.5,13.6-66.8H471.4z M321.2,462c-15.7,5-32.2,8.2-49.2,9.4v32.1c21.2-1.4,41.7-5.4,61.1-11.7L321.2,462z M240,471.4c-18.8-1.4-37-5.2-54.1-11.1l-12.6,29.5c21.1,7.5,43.5,12.2,66.8,13.6V471.4z M462,190.8c5,15.7,8.2,32.2,9.4,49.2h32.1 c-1.4-21.2-5.4-41.7-11.7-61.1L462,190.8z M92.4,397c-12-13.9-22.3-29.4-30.4-46.1l-29.8,11.9c9.9,20.7,22.6,39.8,37.6,56.9 L92.4,397z M272,40.6c18.8,1.4,36.9,5.2,54.1,11.1l12.6-29.5C317.7,14.7,295.3,10,272,8.5V40.6z M190.8,50 c15.7-5,32.2-8.2,49.2-9.4V8.5c-21.2,1.4-41.7,5.4-61.1,11.7L190.8,50z M442.3,92.3L419.6,115c12,13.9,22.3,29.4,30.5,46.1 l29.8-11.9C470,128.5,457.3,109.4,442.3,92.3z M397,92.4l22.7-22.7c-15.6-13.7-32.8-25.5-51.5-34.9l-12.6,29.5 C370.4,72.1,384.4,81.5,397,92.4z",
                    }),
                    Qh({}, Jd, { attributeName: "opacity" }));
            function $d(t) {
                var e = t[0],
                    n = t[1],
                    r = $h(t.slice(4), 1)[0];
                return {
                    found: !0,
                    width: e,
                    height: n,
                    icon: Array.isArray(r)
                        ? {
                              tag: "g",
                              attributes: {
                                  class: ""
                                      .concat(dd.familyPrefix, "-")
                                      .concat(cd.GROUP),
                              },
                              children: [
                                  {
                                      tag: "path",
                                      attributes: {
                                          class: ""
                                              .concat(dd.familyPrefix, "-")
                                              .concat(cd.SECONDARY),
                                          fill: "currentColor",
                                          d: r[0],
                                      },
                                  },
                                  {
                                      tag: "path",
                                      attributes: {
                                          class: ""
                                              .concat(dd.familyPrefix, "-")
                                              .concat(cd.PRIMARY),
                                          fill: "currentColor",
                                          d: r[1],
                                      },
                                  },
                              ],
                          }
                        : {
                              tag: "path",
                              attributes: { fill: "currentColor", d: r },
                          },
                };
            }
            function tp() {
                dd.autoAddCss &&
                    !ip &&
                    ((function (t) {
                        if (t && od) {
                            var e = id.createElement("style");
                            e.setAttribute("type", "text/css"),
                                (e.innerHTML = t);
                            for (
                                var n = id.head.childNodes,
                                    r = null,
                                    s = n.length - 1;
                                s > -1;
                                s--
                            ) {
                                var i = n[s],
                                    o = (i.tagName || "").toUpperCase();
                                ["STYLE", "LINK"].indexOf(o) > -1 && (r = i);
                            }
                            id.head.insertBefore(e, r);
                        }
                    })(
                        (function () {
                            var t = "svg-inline--fa",
                                e = dd.familyPrefix,
                                n = dd.replacementClass,
                                r =
                                    'svg:not(:root).svg-inline--fa {\n  overflow: visible;\n}\n\n.svg-inline--fa {\n  display: inline-block;\n  font-size: inherit;\n  height: 1em;\n  overflow: visible;\n  vertical-align: -0.125em;\n}\n.svg-inline--fa.fa-lg {\n  vertical-align: -0.225em;\n}\n.svg-inline--fa.fa-w-1 {\n  width: 0.0625em;\n}\n.svg-inline--fa.fa-w-2 {\n  width: 0.125em;\n}\n.svg-inline--fa.fa-w-3 {\n  width: 0.1875em;\n}\n.svg-inline--fa.fa-w-4 {\n  width: 0.25em;\n}\n.svg-inline--fa.fa-w-5 {\n  width: 0.3125em;\n}\n.svg-inline--fa.fa-w-6 {\n  width: 0.375em;\n}\n.svg-inline--fa.fa-w-7 {\n  width: 0.4375em;\n}\n.svg-inline--fa.fa-w-8 {\n  width: 0.5em;\n}\n.svg-inline--fa.fa-w-9 {\n  width: 0.5625em;\n}\n.svg-inline--fa.fa-w-10 {\n  width: 0.625em;\n}\n.svg-inline--fa.fa-w-11 {\n  width: 0.6875em;\n}\n.svg-inline--fa.fa-w-12 {\n  width: 0.75em;\n}\n.svg-inline--fa.fa-w-13 {\n  width: 0.8125em;\n}\n.svg-inline--fa.fa-w-14 {\n  width: 0.875em;\n}\n.svg-inline--fa.fa-w-15 {\n  width: 0.9375em;\n}\n.svg-inline--fa.fa-w-16 {\n  width: 1em;\n}\n.svg-inline--fa.fa-w-17 {\n  width: 1.0625em;\n}\n.svg-inline--fa.fa-w-18 {\n  width: 1.125em;\n}\n.svg-inline--fa.fa-w-19 {\n  width: 1.1875em;\n}\n.svg-inline--fa.fa-w-20 {\n  width: 1.25em;\n}\n.svg-inline--fa.fa-pull-left {\n  margin-right: 0.3em;\n  width: auto;\n}\n.svg-inline--fa.fa-pull-right {\n  margin-left: 0.3em;\n  width: auto;\n}\n.svg-inline--fa.fa-border {\n  height: 1.5em;\n}\n.svg-inline--fa.fa-li {\n  width: 2em;\n}\n.svg-inline--fa.fa-fw {\n  width: 1.25em;\n}\n\n.fa-layers svg.svg-inline--fa {\n  bottom: 0;\n  left: 0;\n  margin: auto;\n  position: absolute;\n  right: 0;\n  top: 0;\n}\n\n.fa-layers {\n  display: inline-block;\n  height: 1em;\n  position: relative;\n  text-align: center;\n  vertical-align: -0.125em;\n  width: 1em;\n}\n.fa-layers svg.svg-inline--fa {\n  -webkit-transform-origin: center center;\n          transform-origin: center center;\n}\n\n.fa-layers-counter, .fa-layers-text {\n  display: inline-block;\n  position: absolute;\n  text-align: center;\n}\n\n.fa-layers-text {\n  left: 50%;\n  top: 50%;\n  -webkit-transform: translate(-50%, -50%);\n          transform: translate(-50%, -50%);\n  -webkit-transform-origin: center center;\n          transform-origin: center center;\n}\n\n.fa-layers-counter {\n  background-color: #ff253a;\n  border-radius: 1em;\n  -webkit-box-sizing: border-box;\n          box-sizing: border-box;\n  color: #fff;\n  height: 1.5em;\n  line-height: 1;\n  max-width: 5em;\n  min-width: 1.5em;\n  overflow: hidden;\n  padding: 0.25em;\n  right: 0;\n  text-overflow: ellipsis;\n  top: 0;\n  -webkit-transform: scale(0.25);\n          transform: scale(0.25);\n  -webkit-transform-origin: top right;\n          transform-origin: top right;\n}\n\n.fa-layers-bottom-right {\n  bottom: 0;\n  right: 0;\n  top: auto;\n  -webkit-transform: scale(0.25);\n          transform: scale(0.25);\n  -webkit-transform-origin: bottom right;\n          transform-origin: bottom right;\n}\n\n.fa-layers-bottom-left {\n  bottom: 0;\n  left: 0;\n  right: auto;\n  top: auto;\n  -webkit-transform: scale(0.25);\n          transform: scale(0.25);\n  -webkit-transform-origin: bottom left;\n          transform-origin: bottom left;\n}\n\n.fa-layers-top-right {\n  right: 0;\n  top: 0;\n  -webkit-transform: scale(0.25);\n          transform: scale(0.25);\n  -webkit-transform-origin: top right;\n          transform-origin: top right;\n}\n\n.fa-layers-top-left {\n  left: 0;\n  right: auto;\n  top: 0;\n  -webkit-transform: scale(0.25);\n          transform: scale(0.25);\n  -webkit-transform-origin: top left;\n          transform-origin: top left;\n}\n\n.fa-lg {\n  font-size: 1.3333333333em;\n  line-height: 0.75em;\n  vertical-align: -0.0667em;\n}\n\n.fa-xs {\n  font-size: 0.75em;\n}\n\n.fa-sm {\n  font-size: 0.875em;\n}\n\n.fa-1x {\n  font-size: 1em;\n}\n\n.fa-2x {\n  font-size: 2em;\n}\n\n.fa-3x {\n  font-size: 3em;\n}\n\n.fa-4x {\n  font-size: 4em;\n}\n\n.fa-5x {\n  font-size: 5em;\n}\n\n.fa-6x {\n  font-size: 6em;\n}\n\n.fa-7x {\n  font-size: 7em;\n}\n\n.fa-8x {\n  font-size: 8em;\n}\n\n.fa-9x {\n  font-size: 9em;\n}\n\n.fa-10x {\n  font-size: 10em;\n}\n\n.fa-fw {\n  text-align: center;\n  width: 1.25em;\n}\n\n.fa-ul {\n  list-style-type: none;\n  margin-left: 2.5em;\n  padding-left: 0;\n}\n.fa-ul > li {\n  position: relative;\n}\n\n.fa-li {\n  left: -2em;\n  position: absolute;\n  text-align: center;\n  width: 2em;\n  line-height: inherit;\n}\n\n.fa-border {\n  border: solid 0.08em #eee;\n  border-radius: 0.1em;\n  padding: 0.2em 0.25em 0.15em;\n}\n\n.fa-pull-left {\n  float: left;\n}\n\n.fa-pull-right {\n  float: right;\n}\n\n.fa.fa-pull-left,\n.fas.fa-pull-left,\n.far.fa-pull-left,\n.fal.fa-pull-left,\n.fab.fa-pull-left {\n  margin-right: 0.3em;\n}\n.fa.fa-pull-right,\n.fas.fa-pull-right,\n.far.fa-pull-right,\n.fal.fa-pull-right,\n.fab.fa-pull-right {\n  margin-left: 0.3em;\n}\n\n.fa-spin {\n  -webkit-animation: fa-spin 2s infinite linear;\n          animation: fa-spin 2s infinite linear;\n}\n\n.fa-pulse {\n  -webkit-animation: fa-spin 1s infinite steps(8);\n          animation: fa-spin 1s infinite steps(8);\n}\n\n@-webkit-keyframes fa-spin {\n  0% {\n    -webkit-transform: rotate(0deg);\n            transform: rotate(0deg);\n  }\n  100% {\n    -webkit-transform: rotate(360deg);\n            transform: rotate(360deg);\n  }\n}\n\n@keyframes fa-spin {\n  0% {\n    -webkit-transform: rotate(0deg);\n            transform: rotate(0deg);\n  }\n  100% {\n    -webkit-transform: rotate(360deg);\n            transform: rotate(360deg);\n  }\n}\n.fa-rotate-90 {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=1)";\n  -webkit-transform: rotate(90deg);\n          transform: rotate(90deg);\n}\n\n.fa-rotate-180 {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2)";\n  -webkit-transform: rotate(180deg);\n          transform: rotate(180deg);\n}\n\n.fa-rotate-270 {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=3)";\n  -webkit-transform: rotate(270deg);\n          transform: rotate(270deg);\n}\n\n.fa-flip-horizontal {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=0, mirror=1)";\n  -webkit-transform: scale(-1, 1);\n          transform: scale(-1, 1);\n}\n\n.fa-flip-vertical {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)";\n  -webkit-transform: scale(1, -1);\n          transform: scale(1, -1);\n}\n\n.fa-flip-both, .fa-flip-horizontal.fa-flip-vertical {\n  -ms-filter: "progid:DXImageTransform.Microsoft.BasicImage(rotation=2, mirror=1)";\n  -webkit-transform: scale(-1, -1);\n          transform: scale(-1, -1);\n}\n\n:root .fa-rotate-90,\n:root .fa-rotate-180,\n:root .fa-rotate-270,\n:root .fa-flip-horizontal,\n:root .fa-flip-vertical,\n:root .fa-flip-both {\n  -webkit-filter: none;\n          filter: none;\n}\n\n.fa-stack {\n  display: inline-block;\n  height: 2em;\n  position: relative;\n  width: 2.5em;\n}\n\n.fa-stack-1x,\n.fa-stack-2x {\n  bottom: 0;\n  left: 0;\n  margin: auto;\n  position: absolute;\n  right: 0;\n  top: 0;\n}\n\n.svg-inline--fa.fa-stack-1x {\n  height: 1em;\n  width: 1.25em;\n}\n.svg-inline--fa.fa-stack-2x {\n  height: 2em;\n  width: 2.5em;\n}\n\n.fa-inverse {\n  color: #fff;\n}\n\n.sr-only {\n  border: 0;\n  clip: rect(0, 0, 0, 0);\n  height: 1px;\n  margin: -1px;\n  overflow: hidden;\n  padding: 0;\n  position: absolute;\n  width: 1px;\n}\n\n.sr-only-focusable:active, .sr-only-focusable:focus {\n  clip: auto;\n  height: auto;\n  margin: 0;\n  overflow: visible;\n  position: static;\n  width: auto;\n}\n\n.svg-inline--fa .fa-primary {\n  fill: var(--fa-primary-color, currentColor);\n  opacity: 1;\n  opacity: var(--fa-primary-opacity, 1);\n}\n\n.svg-inline--fa .fa-secondary {\n  fill: var(--fa-secondary-color, currentColor);\n  opacity: 0.4;\n  opacity: var(--fa-secondary-opacity, 0.4);\n}\n\n.svg-inline--fa.fa-swap-opacity .fa-primary {\n  opacity: 0.4;\n  opacity: var(--fa-secondary-opacity, 0.4);\n}\n\n.svg-inline--fa.fa-swap-opacity .fa-secondary {\n  opacity: 1;\n  opacity: var(--fa-primary-opacity, 1);\n}\n\n.svg-inline--fa mask .fa-primary,\n.svg-inline--fa mask .fa-secondary {\n  fill: black;\n}\n\n.fad.fa-inverse {\n  color: #fff;\n}';
                            if ("fa" !== e || n !== t) {
                                var s = new RegExp(
                                        "\\.".concat("fa", "\\-"),
                                        "g"
                                    ),
                                    i = new RegExp(
                                        "\\--".concat("fa", "\\-"),
                                        "g"
                                    ),
                                    o = new RegExp("\\.".concat(t), "g");
                                r = r
                                    .replace(s, ".".concat(e, "-"))
                                    .replace(i, "--".concat(e, "-"))
                                    .replace(o, ".".concat(n));
                            }
                            return r;
                        })()
                    ),
                    (ip = !0));
            }
            function ep(t, e) {
                return (
                    Object.defineProperty(t, "abstract", { get: e }),
                    Object.defineProperty(t, "html", {
                        get: function () {
                            return t.abstract.map(function (t) {
                                return Yd(t);
                            });
                        },
                    }),
                    Object.defineProperty(t, "node", {
                        get: function () {
                            if (od) {
                                var e = id.createElement("div");
                                return (e.innerHTML = t.html), e.children;
                            }
                        },
                    }),
                    t
                );
            }
            function np(t) {
                var e = t.prefix,
                    n = void 0 === e ? "fa" : e,
                    r = t.iconName;
                if (r) return Zd(sp.definitions, n, r) || Zd(fd.styles, n, r);
            }
            Qh({}, Xd, { cx: "256", cy: "364", r: "28" }),
                Qh({}, Jd, {
                    attributeName: "r",
                    values: "28;14;28;28;14;28;",
                }),
                Qh({}, Qd, { values: "1;0;1;1;0;1;" }),
                Qh({}, Xd, {
                    opacity: "1",
                    d: "M263.7,312h-16c-6.6,0-12-5.4-12-12c0-71,77.4-63.9,77.4-107.8c0-20-17.8-40.2-57.4-40.2c-29.1,0-44.3,9.6-59.2,28.7 c-3.9,5-11.1,6-16.2,2.4l-13.1-9.2c-5.6-3.9-6.9-11.8-2.6-17.2c21.2-27.2,46.4-44.7,91.2-44.7c52.3,0,97.4,29.8,97.4,80.2 c0,67.6-77.4,63.5-77.4,107.8C275.7,306.6,270.3,312,263.7,312z",
                }),
                Qh({}, Qd, { values: "1;0;0;0;0;1;" }),
                Qh({}, Xd, {
                    opacity: "0",
                    d: "M232.5,134.5l7,168c0.3,6.4,5.6,11.5,12,11.5h9c6.4,0,11.7-5.1,12-11.5l7-168c0.3-6.8-5.2-12.5-12-12.5h-23 C237.7,122,232.2,127.7,232.5,134.5z",
                }),
                Qh({}, Qd, { values: "0;0;1;1;0;0;" });
            var rp,
                sp = new ((function () {
                    function t() {
                        !(function (t, e) {
                            if (!(t instanceof e))
                                throw new TypeError(
                                    "Cannot call a class as a function"
                                );
                        })(this, t),
                            (this.definitions = {});
                    }
                    var e;
                    return (
                        (e = [
                            {
                                key: "add",
                                value: function () {
                                    for (
                                        var t = this,
                                            e = arguments.length,
                                            n = new Array(e),
                                            r = 0;
                                        r < e;
                                        r++
                                    )
                                        n[r] = arguments[r];
                                    var s = n.reduce(this._pullDefinitions, {});
                                    Object.keys(s).forEach(function (e) {
                                        (t.definitions[e] = Qh(
                                            {},
                                            t.definitions[e] || {},
                                            s[e]
                                        )),
                                            qd(e, s[e]),
                                            Ud();
                                    });
                                },
                            },
                            {
                                key: "reset",
                                value: function () {
                                    this.definitions = {};
                                },
                            },
                            {
                                key: "_pullDefinitions",
                                value: function (t, e) {
                                    var n =
                                        e.prefix && e.iconName && e.icon
                                            ? { 0: e }
                                            : e;
                                    return (
                                        Object.keys(n).map(function (e) {
                                            var r = n[e],
                                                s = r.prefix,
                                                i = r.iconName,
                                                o = r.icon;
                                            t[s] || (t[s] = {}), (t[s][i] = o);
                                        }),
                                        t
                                    );
                                },
                            },
                        ]) &&
                            (function (t, e) {
                                for (var n = 0; n < e.length; n++) {
                                    var r = e[n];
                                    (r.enumerable = r.enumerable || !1),
                                        (r.configurable = !0),
                                        "value" in r && (r.writable = !0),
                                        Object.defineProperty(t, r.key, r);
                                }
                            })(t.prototype, e),
                        t
                    );
                })())(),
                ip = !1,
                op =
                    ((rp = function (t) {
                        var e =
                                arguments.length > 1 && void 0 !== arguments[1]
                                    ? arguments[1]
                                    : {},
                            n = e.transform,
                            r = void 0 === n ? Rd : n,
                            s = e.symbol,
                            i = void 0 !== s && s,
                            o = e.mask,
                            a = void 0 === o ? null : o,
                            l = e.maskId,
                            c = void 0 === l ? null : l,
                            u = e.title,
                            h = void 0 === u ? null : u,
                            d = e.titleId,
                            p = void 0 === d ? null : d,
                            f = e.classes,
                            g = void 0 === f ? [] : f,
                            m = e.attributes,
                            y = void 0 === m ? {} : m,
                            v = e.styles,
                            b = void 0 === v ? {} : v;
                        if (t) {
                            var w = t.prefix,
                                C = t.iconName,
                                x = t.icon;
                            return ep(Qh({ type: "icon" }, t), function () {
                                return (
                                    tp(),
                                    dd.autoA11y &&
                                        (h
                                            ? (y["aria-labelledby"] = ""
                                                  .concat(
                                                      dd.replacementClass,
                                                      "-title-"
                                                  )
                                                  .concat(p || Nd()))
                                            : ((y["aria-hidden"] = "true"),
                                              (y.focusable = "false"))),
                                    Hd({
                                        icons: {
                                            main: $d(x),
                                            mask: a
                                                ? $d(a.icon)
                                                : {
                                                      found: !1,
                                                      width: null,
                                                      height: null,
                                                      icon: {},
                                                  },
                                        },
                                        prefix: w,
                                        iconName: C,
                                        transform: Qh({}, Rd, r),
                                        symbol: i,
                                        title: h,
                                        maskId: c,
                                        titleId: p,
                                        extra: {
                                            attributes: y,
                                            styles: b,
                                            classes: g,
                                        },
                                    })
                                );
                            });
                        }
                    }),
                    function (t) {
                        var e =
                                arguments.length > 1 && void 0 !== arguments[1]
                                    ? arguments[1]
                                    : {},
                            n = (t || {}).icon ? t : np(t || {}),
                            r = e.mask;
                        return (
                            r && (r = (r || {}).icon ? r : np(r || {})),
                            rp(n, Qh({}, e, { mask: r }))
                        );
                    });
            const ap = ["*"];
            let lp = (() => {
                    class t {
                        constructor() {
                            (this.defaultPrefix = "fas"),
                                (this.fallbackIcon = null),
                                (this.globalLibrary = !1);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({
                            factory: function () {
                                return new t();
                            },
                            token: t,
                            providedIn: "root",
                        })),
                        t
                    );
                })(),
                cp = (() => {
                    class t {
                        constructor() {
                            this.definitions = {};
                        }
                        addIcons(...t) {
                            for (const e of t)
                                e.prefix in this.definitions ||
                                    (this.definitions[e.prefix] = {}),
                                    (this.definitions[e.prefix][e.iconName] =
                                        e);
                        }
                        addIconPacks(...t) {
                            for (const e of t) {
                                const t = Object.keys(e).map((t) => e[t]);
                                this.addIcons(...t);
                            }
                        }
                        getIconDefinition(t, e) {
                            return t in this.definitions &&
                                e in this.definitions[t]
                                ? this.definitions[t][e]
                                : null;
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({
                            factory: function () {
                                return new t();
                            },
                            token: t,
                            providedIn: "root",
                        })),
                        t
                    );
                })();
            const up = (t) => {
                const e = {
                    "fa-spin": t.spin,
                    "fa-pulse": t.pulse,
                    "fa-fw": t.fixedWidth,
                    "fa-border": t.border,
                    "fa-inverse": t.inverse,
                    "fa-layers-counter": t.counter,
                    "fa-flip-horizontal":
                        "horizontal" === t.flip || "both" === t.flip,
                    "fa-flip-vertical":
                        "vertical" === t.flip || "both" === t.flip,
                    [`fa-${t.size}`]: null !== t.size,
                    [`fa-rotate-${t.rotate}`]: null !== t.rotate,
                    [`fa-pull-${t.pull}`]: null !== t.pull,
                    [`fa-stack-${t.stackItemSize}`]: null != t.stackItemSize,
                };
                return Object.keys(e)
                    .map((t) => (e[t] ? t : null))
                    .filter((t) => t);
            };
            let hp = (() => {
                    class t {
                        constructor() {
                            this.stackItemSize = "1x";
                        }
                        ngOnChanges(t) {
                            if ("size" in t)
                                throw new Error(
                                    'fa-icon is not allowed to customize size when used inside fa-stack. Set size on the enclosing fa-stack instead: <fa-stack size="4x">...</fa-stack>.'
                                );
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵdir = Ht({
                            type: t,
                            selectors: [
                                ["fa-icon", "stackItemSize", ""],
                                ["fa-duotone-icon", "stackItemSize", ""],
                            ],
                            inputs: {
                                stackItemSize: "stackItemSize",
                                size: "size",
                            },
                            features: [ne],
                        })),
                        t
                    );
                })(),
                dp = (() => {
                    class t {
                        constructor(t, e) {
                            (this.renderer = t), (this.elementRef = e);
                        }
                        ngOnInit() {
                            this.renderer.addClass(
                                this.elementRef.nativeElement,
                                "fa-stack"
                            );
                        }
                        ngOnChanges(t) {
                            "size" in t &&
                                (null != t.size.currentValue &&
                                    this.renderer.addClass(
                                        this.elementRef.nativeElement,
                                        `fa-${t.size.currentValue}`
                                    ),
                                null != t.size.previousValue &&
                                    this.renderer.removeClass(
                                        this.elementRef.nativeElement,
                                        `fa-${t.size.previousValue}`
                                    ));
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(Ro(Na), Ro(Ma));
                        }),
                        (t.ɵcmp = Dt({
                            type: t,
                            selectors: [["fa-stack"]],
                            inputs: { size: "size" },
                            features: [ne],
                            ngContentSelectors: ap,
                            decls: 1,
                            vars: 0,
                            template: function (t, e) {
                                1 & t &&
                                    ((function (t) {
                                        const e = ke()[16][6];
                                        if (!e.projection) {
                                            const t = (e.projection = Hn(
                                                    1,
                                                    null
                                                )),
                                                n = t.slice();
                                            let r = e.child;
                                            for (; null !== r; ) {
                                                const e = 0;
                                                null !== e &&
                                                    (n[e]
                                                        ? (n[e].projectionNext =
                                                              r)
                                                        : (t[e] = r),
                                                    (n[e] = r)),
                                                    (r = r.next);
                                            }
                                        }
                                    })(),
                                    (function (t, e = 0, n) {
                                        const r = ke(),
                                            s = Ae(),
                                            i = Js(
                                                s,
                                                20 + t,
                                                16,
                                                null,
                                                n || null
                                            );
                                        null === i.projection &&
                                            (i.projection = e),
                                            Me(),
                                            64 != (64 & i.flags) &&
                                                (function (t, e, n) {
                                                    Is(
                                                        e[11],
                                                        0,
                                                        e,
                                                        n,
                                                        gs(t, n, e),
                                                        ws(
                                                            n.parent || e[6],
                                                            n,
                                                            e
                                                        )
                                                    );
                                                })(s, r, i);
                                    })(0));
                            },
                            encapsulation: 2,
                        })),
                        t
                    );
                })(),
                pp = (() => {
                    class t {
                        constructor(t, e, n, r, s) {
                            (this.sanitizer = t),
                                (this.config = e),
                                (this.iconLibrary = n),
                                (this.stackItem = r),
                                (this.classes = []),
                                null != s &&
                                    null == r &&
                                    console.error(
                                        'FontAwesome: fa-icon and fa-duotone-icon elements must specify stackItemSize attribute when wrapped into fa-stack. Example: <fa-icon stackItemSize="2x"></fa-icon>.'
                                    );
                        }
                        ngOnChanges(t) {
                            if (
                                null == this.icon &&
                                null == this.config.fallbackIcon
                            )
                                return (() => {
                                    throw new Error(
                                        "Property `icon` is required for `fa-icon`/`fa-duotone-icon` components."
                                    );
                                })();
                            let e = null;
                            if (
                                ((e =
                                    null == this.icon
                                        ? this.config.fallbackIcon
                                        : this.icon),
                                t)
                            ) {
                                const t = this.findIconDefinition(e);
                                if (null != t) {
                                    const e = this.buildParams();
                                    this.renderIcon(t, e);
                                }
                            }
                        }
                        render() {
                            this.ngOnChanges({});
                        }
                        findIconDefinition(t) {
                            const e = ((t, e) => {
                                return void 0 !== (n = t).prefix &&
                                    void 0 !== n.iconName
                                    ? t
                                    : Array.isArray(t) && 2 === t.length
                                    ? { prefix: t[0], iconName: t[1] }
                                    : "string" == typeof t
                                    ? { prefix: e, iconName: t }
                                    : void 0;
                                var n;
                            })(t, this.config.defaultPrefix);
                            if ("icon" in e) return e;
                            const n = this.iconLibrary.getIconDefinition(
                                e.prefix,
                                e.iconName
                            );
                            if (null != n) return n;
                            const r = np(e);
                            if (null != r) {
                                const t =
                                    "Global icon library is deprecated. Consult https://github.com/FortAwesome/angular-fontawesome/blob/master/UPGRADING.md for the migration instructions.";
                                if ("unset" === this.config.globalLibrary)
                                    console.error("FontAwesome: " + t);
                                else if (!this.config.globalLibrary)
                                    throw new Error(t);
                                return r;
                            }
                            return (
                                ((t) => {
                                    throw new Error(
                                        `Could not find icon with iconName=${t.iconName} and prefix=${t.prefix} in the icon library.`
                                    );
                                })(e),
                                null
                            );
                        }
                        buildParams() {
                            const t = {
                                    flip: this.flip,
                                    spin: this.spin,
                                    pulse: this.pulse,
                                    border: this.border,
                                    inverse: this.inverse,
                                    size: this.size || null,
                                    pull: this.pull || null,
                                    rotate: this.rotate || null,
                                    fixedWidth:
                                        "boolean" == typeof this.fixedWidth
                                            ? this.fixedWidth
                                            : this.config.fixedWidth,
                                    stackItemSize:
                                        null != this.stackItem
                                            ? this.stackItem.stackItemSize
                                            : null,
                                },
                                e =
                                    "string" == typeof this.transform
                                        ? (function (t) {
                                              var e = {
                                                  size: 16,
                                                  x: 0,
                                                  y: 0,
                                                  flipX: !1,
                                                  flipY: !1,
                                                  rotate: 0,
                                              };
                                              return t
                                                  ? t
                                                        .toLowerCase()
                                                        .split(" ")
                                                        .reduce(function (
                                                            t,
                                                            e
                                                        ) {
                                                            var n = e
                                                                    .toLowerCase()
                                                                    .split("-"),
                                                                r = n[0],
                                                                s = n
                                                                    .slice(1)
                                                                    .join("-");
                                                            if (r && "h" === s)
                                                                return (
                                                                    (t.flipX =
                                                                        !0),
                                                                    t
                                                                );
                                                            if (r && "v" === s)
                                                                return (
                                                                    (t.flipY =
                                                                        !0),
                                                                    t
                                                                );
                                                            if (
                                                                ((s =
                                                                    parseFloat(
                                                                        s
                                                                    )),
                                                                isNaN(s))
                                                            )
                                                                return t;
                                                            switch (r) {
                                                                case "grow":
                                                                    t.size =
                                                                        t.size +
                                                                        s;
                                                                    break;
                                                                case "shrink":
                                                                    t.size =
                                                                        t.size -
                                                                        s;
                                                                    break;
                                                                case "left":
                                                                    t.x =
                                                                        t.x - s;
                                                                    break;
                                                                case "right":
                                                                    t.x =
                                                                        t.x + s;
                                                                    break;
                                                                case "up":
                                                                    t.y =
                                                                        t.y - s;
                                                                    break;
                                                                case "down":
                                                                    t.y =
                                                                        t.y + s;
                                                                    break;
                                                                case "rotate":
                                                                    t.rotate =
                                                                        t.rotate +
                                                                        s;
                                                            }
                                                            return t;
                                                        },
                                                        e)
                                                  : e;
                                          })(this.transform)
                                        : this.transform;
                            return {
                                title: this.title,
                                transform: e,
                                classes: [...up(t), ...this.classes],
                                mask:
                                    null != this.mask
                                        ? this.findIconDefinition(this.mask)
                                        : null,
                                styles: null != this.styles ? this.styles : {},
                                symbol: this.symbol,
                                attributes: { role: this.a11yRole },
                            };
                        }
                        renderIcon(t, e) {
                            const n = op(t, e);
                            this.renderedIconHTML =
                                this.sanitizer.bypassSecurityTrustHtml(
                                    n.html.join("\n")
                                );
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(
                                Ro(Iu),
                                Ro(lp),
                                Ro(cp),
                                Ro(hp, 8),
                                Ro(dp, 8)
                            );
                        }),
                        (t.ɵcmp = Dt({
                            type: t,
                            selectors: [["fa-icon"]],
                            hostAttrs: [1, "ng-fa-icon"],
                            hostVars: 2,
                            hostBindings: function (t, e) {
                                2 & t &&
                                    (ya("innerHTML", e.renderedIconHTML, Yr),
                                    oo("title", e.title));
                            },
                            inputs: {
                                classes: "classes",
                                icon: "icon",
                                title: "title",
                                spin: "spin",
                                pulse: "pulse",
                                mask: "mask",
                                styles: "styles",
                                flip: "flip",
                                size: "size",
                                pull: "pull",
                                border: "border",
                                inverse: "inverse",
                                symbol: "symbol",
                                rotate: "rotate",
                                fixedWidth: "fixedWidth",
                                transform: "transform",
                                a11yRole: "a11yRole",
                            },
                            features: [ne],
                            decls: 0,
                            vars: 0,
                            template: function (t, e) {},
                            encapsulation: 2,
                        })),
                        t
                    );
                })(),
                fp = (() => {
                    class t {}
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)();
                            },
                        })),
                        t
                    );
                })();
            const gp = ["dialogPopup"],
                mp = ["hueSlider"],
                yp = ["alphaSlider"];
            function vp(t, e) {
                if ((1 & t && jo(0, "div"), 2 & t)) {
                    const t = Uo();
                    "arrow arrow-",
                        (n = t.cpUsePosition),
                        "",
                        ia(Ln, ra, ao(ke(), "arrow arrow-", n, ""), !0),
                        ta("top", t.arrowTop, "px");
                }
                var n;
            }
            function bp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 26),
                        qo("newValue", function (e) {
                            return Ee(t), Uo().onColorChange(e);
                        })("dragStart", function () {
                            return (
                                Ee(t), Uo().onDragStart("saturation-lightness")
                            );
                        })("dragEnd", function () {
                            return (
                                Ee(t), Uo().onDragEnd("saturation-lightness")
                            );
                        }),
                        jo(1, "div", 13),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    ta("background-color", t.hueSliderColor),
                        No("rgX", 1)("rgY", 1),
                        Hs(1),
                        ta("top", null == t.slider ? null : t.slider.v, "px")(
                            "left",
                            null == t.slider ? null : t.slider.s,
                            "px"
                        );
                }
            }
            function wp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "button", 27),
                        qo("click", function (e) {
                            Ee(t);
                            const n = Uo();
                            return n.onAddPresetColor(e, n.selectedColor);
                        }),
                        fa(1),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    na(t.cpAddColorButtonClass),
                        No(
                            "disabled",
                            t.cpPresetColors &&
                                t.cpPresetColors.length >=
                                    t.cpMaxPresetColorsLength
                        ),
                        Hs(1),
                        ma(" ", t.cpAddColorButtonText, " ");
                }
            }
            function Cp(t, e) {
                1 & t && jo(0, "div", 28);
            }
            function xp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "input", 34),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo(2).onAlphaInput(e);
                        }),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    No("rg", 1)(
                        "value",
                        null == t.cmykText ? null : t.cmykText.a
                    );
                }
            }
            function _p(t, e) {
                1 & t && (Vo(0, "div"), fa(1, "A"), Fo());
            }
            function kp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 29),
                        Vo(1, "div", 30),
                        Vo(2, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onCyanInput(e);
                        }),
                        Fo(),
                        Vo(3, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onMagentaInput(e);
                        }),
                        Fo(),
                        Vo(4, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onYellowInput(e);
                        }),
                        Fo(),
                        Vo(5, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onBlackInput(e);
                        }),
                        Fo(),
                        lo(6, xp, 1, 2, "input", 32),
                        Fo(),
                        Vo(7, "div", 30),
                        Vo(8, "div"),
                        fa(9, "C"),
                        Fo(),
                        Vo(10, "div"),
                        fa(11, "M"),
                        Fo(),
                        Vo(12, "div"),
                        fa(13, "Y"),
                        Fo(),
                        Vo(14, "div"),
                        fa(15, "K"),
                        Fo(),
                        lo(16, _p, 2, 0, "div", 33),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    ta("display", 3 !== t.format ? "none" : "block"),
                        Hs(2),
                        No("rg", 100)(
                            "value",
                            null == t.cmykText ? null : t.cmykText.c
                        ),
                        Hs(1),
                        No("rg", 100)(
                            "value",
                            null == t.cmykText ? null : t.cmykText.m
                        ),
                        Hs(1),
                        No("rg", 100)(
                            "value",
                            null == t.cmykText ? null : t.cmykText.y
                        ),
                        Hs(1),
                        No("rg", 100)(
                            "value",
                            null == t.cmykText ? null : t.cmykText.k
                        ),
                        Hs(1),
                        No("ngIf", "disabled" !== t.cpAlphaChannel),
                        Hs(10),
                        No("ngIf", "disabled" !== t.cpAlphaChannel);
                }
            }
            function Ap(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "input", 34),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo(2).onAlphaInput(e);
                        }),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    No("rg", 1)(
                        "value",
                        null == t.hslaText ? null : t.hslaText.a
                    );
                }
            }
            function Ep(t, e) {
                1 & t && (Vo(0, "div"), fa(1, "A"), Fo());
            }
            function Ip(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 35),
                        Vo(1, "div", 30),
                        Vo(2, "input", 36),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onHueInput(e);
                        }),
                        Fo(),
                        Vo(3, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onSaturationInput(e);
                        }),
                        Fo(),
                        Vo(4, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onLightnessInput(e);
                        }),
                        Fo(),
                        lo(5, Ap, 1, 2, "input", 32),
                        Fo(),
                        Vo(6, "div", 30),
                        Vo(7, "div"),
                        fa(8, "H"),
                        Fo(),
                        Vo(9, "div"),
                        fa(10, "S"),
                        Fo(),
                        Vo(11, "div"),
                        fa(12, "L"),
                        Fo(),
                        lo(13, Ep, 2, 0, "div", 33),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    ta("display", 2 !== t.format ? "none" : "block"),
                        Hs(2),
                        No("rg", 360)(
                            "value",
                            null == t.hslaText ? null : t.hslaText.h
                        ),
                        Hs(1),
                        No("rg", 100)(
                            "value",
                            null == t.hslaText ? null : t.hslaText.s
                        ),
                        Hs(1),
                        No("rg", 100)(
                            "value",
                            null == t.hslaText ? null : t.hslaText.l
                        ),
                        Hs(1),
                        No("ngIf", "disabled" !== t.cpAlphaChannel),
                        Hs(8),
                        No("ngIf", "disabled" !== t.cpAlphaChannel);
                }
            }
            function Tp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "input", 34),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo(2).onAlphaInput(e);
                        }),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    No("rg", 1)(
                        "value",
                        null == t.rgbaText ? null : t.rgbaText.a
                    );
                }
            }
            function Sp(t, e) {
                1 & t && (Vo(0, "div"), fa(1, "A"), Fo());
            }
            function Op(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 37),
                        Vo(1, "div", 30),
                        Vo(2, "input", 38),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onRedInput(e);
                        }),
                        Fo(),
                        Vo(3, "input", 38),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onGreenInput(e);
                        }),
                        Fo(),
                        Vo(4, "input", 38),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onBlueInput(e);
                        }),
                        Fo(),
                        lo(5, Tp, 1, 2, "input", 32),
                        Fo(),
                        Vo(6, "div", 30),
                        Vo(7, "div"),
                        fa(8, "R"),
                        Fo(),
                        Vo(9, "div"),
                        fa(10, "G"),
                        Fo(),
                        Vo(11, "div"),
                        fa(12, "B"),
                        Fo(),
                        lo(13, Sp, 2, 0, "div", 33),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    ta("display", 1 !== t.format ? "none" : "block"),
                        Hs(2),
                        No("rg", 255)(
                            "value",
                            null == t.rgbaText ? null : t.rgbaText.r
                        ),
                        Hs(1),
                        No("rg", 255)(
                            "value",
                            null == t.rgbaText ? null : t.rgbaText.g
                        ),
                        Hs(1),
                        No("rg", 255)(
                            "value",
                            null == t.rgbaText ? null : t.rgbaText.b
                        ),
                        Hs(1),
                        No("ngIf", "disabled" !== t.cpAlphaChannel),
                        Hs(8),
                        No("ngIf", "disabled" !== t.cpAlphaChannel);
                }
            }
            function Mp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "input", 34),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo(2).onAlphaInput(e);
                        }),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    No("rg", 1)("value", t.hexAlpha);
                }
            }
            function Pp(t, e) {
                1 & t && (Vo(0, "div"), fa(1, "A"), Fo());
            }
            function Rp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 39),
                        Vo(1, "div", 30),
                        Vo(2, "input", 40),
                        qo("blur", function () {
                            return Ee(t), Uo().onHexInput(null);
                        })("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onHexInput(e);
                        }),
                        Fo(),
                        lo(3, Mp, 1, 2, "input", 32),
                        Fo(),
                        Vo(4, "div", 30),
                        Vo(5, "div"),
                        fa(6, "Hex"),
                        Fo(),
                        lo(7, Pp, 2, 0, "div", 33),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    ta("display", 0 !== t.format ? "none" : "block"),
                        ea("hex-alpha", "forced" === t.cpAlphaChannel),
                        Hs(2),
                        No("value", t.hexText),
                        Hs(1),
                        No("ngIf", "forced" === t.cpAlphaChannel),
                        Hs(4),
                        No("ngIf", "forced" === t.cpAlphaChannel);
                }
            }
            function Np(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "input", 34),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo(2).onAlphaInput(e);
                        }),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    No("rg", 1)(
                        "value",
                        null == t.hslaText ? null : t.hslaText.a
                    );
                }
            }
            function Dp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 41),
                        Vo(1, "div", 30),
                        Vo(2, "input", 31),
                        qo("keyup.enter", function (e) {
                            return Ee(t), Uo().onAcceptColor(e);
                        })("newValue", function (e) {
                            return Ee(t), Uo().onValueInput(e);
                        }),
                        Fo(),
                        lo(3, Np, 1, 2, "input", 32),
                        Fo(),
                        Vo(4, "div", 30),
                        Vo(5, "div"),
                        fa(6, "V"),
                        Fo(),
                        Vo(7, "div"),
                        fa(8, "A"),
                        Fo(),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo();
                    Hs(2),
                        No("rg", 100)(
                            "value",
                            null == t.hslaText ? null : t.hslaText.l
                        ),
                        Hs(1),
                        No("ngIf", "disabled" !== t.cpAlphaChannel);
                }
            }
            function Vp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 42),
                        Vo(1, "span", 43),
                        qo("click", function () {
                            return Ee(t), Uo().onFormatToggle(-1);
                        }),
                        Fo(),
                        Vo(2, "span", 43),
                        qo("click", function () {
                            return Ee(t), Uo().onFormatToggle(1);
                        }),
                        Fo(),
                        Fo();
                }
            }
            function Fp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "span", 50),
                        qo("click", function (e) {
                            Ee(t);
                            const n = Uo().$implicit;
                            return Uo(3).onRemovePresetColor(e, n);
                        }),
                        Fo();
                }
                2 & t && na(Uo(4).cpRemoveColorButtonClass);
            }
            function jp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 48),
                        qo("click", function () {
                            Ee(t);
                            const n = e.$implicit;
                            return Uo(3).setColorFromString(n);
                        }),
                        lo(1, Fp, 1, 3, "span", 49),
                        Fo();
                }
                if (2 & t) {
                    const t = e.$implicit,
                        n = Uo(3);
                    ta("background-color", t),
                        Hs(1),
                        No("ngIf", n.cpAddColorButton);
                }
            }
            function zp(t, e) {
                if (
                    (1 & t && (Vo(0, "div"), lo(1, jp, 2, 3, "div", 47), Fo()),
                    2 & t)
                ) {
                    const t = Uo(2);
                    na(t.cpPresetColorsClass),
                        Hs(1),
                        No("ngForOf", t.cpPresetColors);
                }
            }
            function Bp(t, e) {
                if ((1 & t && (Vo(0, "div"), fa(1), Fo()), 2 & t)) {
                    const t = Uo(2);
                    na(t.cpPresetEmptyMessageClass),
                        Hs(1),
                        ga(t.cpPresetEmptyMessage);
                }
            }
            function Hp(t, e) {
                if (
                    (1 & t &&
                        (Vo(0, "div", 44),
                        jo(1, "hr"),
                        Vo(2, "div", 45),
                        fa(3),
                        Fo(),
                        lo(4, zp, 2, 4, "div", 46),
                        lo(5, Bp, 2, 4, "div", 46),
                        Fo()),
                    2 & t)
                ) {
                    const t = Uo();
                    Hs(3),
                        ga(t.cpPresetLabel),
                        Hs(1),
                        No(
                            "ngIf",
                            null == t.cpPresetColors
                                ? null
                                : t.cpPresetColors.length
                        ),
                        Hs(1),
                        No(
                            "ngIf",
                            !(
                                null != t.cpPresetColors &&
                                t.cpPresetColors.length
                            ) && t.cpAddColorButton
                        );
                }
            }
            function Lp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "button", 53),
                        qo("click", function (e) {
                            return Ee(t), Uo(2).onCancelColor(e);
                        }),
                        fa(1),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    na(t.cpCancelButtonClass), Hs(1), ga(t.cpCancelButtonText);
                }
            }
            function qp(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "button", 53),
                        qo("click", function (e) {
                            return Ee(t), Uo(2).onAcceptColor(e);
                        }),
                        fa(1),
                        Fo();
                }
                if (2 & t) {
                    const t = Uo(2);
                    na(t.cpOKButtonClass), Hs(1), ga(t.cpOKButtonText);
                }
            }
            function Kp(t, e) {
                if (
                    (1 & t &&
                        (Vo(0, "div", 51),
                        lo(1, Lp, 2, 4, "button", 52),
                        lo(2, qp, 2, 4, "button", 52),
                        Fo()),
                    2 & t)
                ) {
                    const t = Uo();
                    Hs(1),
                        No("ngIf", t.cpCancelButton),
                        Hs(1),
                        No("ngIf", t.cpOKButton);
                }
            }
            var Wp = (function (t) {
                return (
                    (t[(t.HEX = 0)] = "HEX"),
                    (t[(t.RGBA = 1)] = "RGBA"),
                    (t[(t.HSLA = 2)] = "HSLA"),
                    (t[(t.CMYK = 3)] = "CMYK"),
                    t
                );
            })({});
            class Up {
                constructor(t, e, n, r) {
                    (this.r = t), (this.g = e), (this.b = n), (this.a = r);
                }
            }
            class Zp {
                constructor(t, e, n, r) {
                    (this.h = t), (this.s = e), (this.v = n), (this.a = r);
                }
            }
            class Yp {
                constructor(t, e, n, r) {
                    (this.h = t), (this.s = e), (this.l = n), (this.a = r);
                }
            }
            class Gp {
                constructor(t, e, n, r, s = 1) {
                    (this.c = t),
                        (this.m = e),
                        (this.y = n),
                        (this.k = r),
                        (this.a = s);
                }
            }
            let Xp = (() => {
                    class t {
                        constructor() {
                            this.newValue = new Rl();
                        }
                        inputChange(t) {
                            const e = t.target.value;
                            if (void 0 === this.rg) this.newValue.emit(e);
                            else {
                                const t = parseFloat(e);
                                this.newValue.emit({ v: t, rg: this.rg });
                            }
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵdir = Ht({
                            type: t,
                            selectors: [["", "text", ""]],
                            hostBindings: function (t, e) {
                                1 & t &&
                                    qo("input", function (t) {
                                        return e.inputChange(t);
                                    });
                            },
                            inputs: { rg: "rg", text: "text" },
                            outputs: { newValue: "newValue" },
                        })),
                        t
                    );
                })(),
                Jp = (() => {
                    class t {
                        constructor(t) {
                            (this.elRef = t),
                                (this.dragEnd = new Rl()),
                                (this.dragStart = new Rl()),
                                (this.newValue = new Rl()),
                                (this.listenerMove = (t) => this.move(t)),
                                (this.listenerStop = () => this.stop());
                        }
                        mouseDown(t) {
                            this.start(t);
                        }
                        touchStart(t) {
                            this.start(t);
                        }
                        move(t) {
                            t.preventDefault(), this.setCursor(t);
                        }
                        start(t) {
                            this.setCursor(t),
                                t.stopPropagation(),
                                document.addEventListener(
                                    "mouseup",
                                    this.listenerStop
                                ),
                                document.addEventListener(
                                    "touchend",
                                    this.listenerStop
                                ),
                                document.addEventListener(
                                    "mousemove",
                                    this.listenerMove
                                ),
                                document.addEventListener(
                                    "touchmove",
                                    this.listenerMove
                                ),
                                this.dragStart.emit();
                        }
                        stop() {
                            document.removeEventListener(
                                "mouseup",
                                this.listenerStop
                            ),
                                document.removeEventListener(
                                    "touchend",
                                    this.listenerStop
                                ),
                                document.removeEventListener(
                                    "mousemove",
                                    this.listenerMove
                                ),
                                document.removeEventListener(
                                    "touchmove",
                                    this.listenerMove
                                ),
                                this.dragEnd.emit();
                        }
                        getX(t) {
                            const e =
                                this.elRef.nativeElement.getBoundingClientRect();
                            return (
                                (void 0 !== t.pageX
                                    ? t.pageX
                                    : t.touches[0].pageX) -
                                e.left -
                                window.pageXOffset
                            );
                        }
                        getY(t) {
                            const e =
                                this.elRef.nativeElement.getBoundingClientRect();
                            return (
                                (void 0 !== t.pageY
                                    ? t.pageY
                                    : t.touches[0].pageY) -
                                e.top -
                                window.pageYOffset
                            );
                        }
                        setCursor(t) {
                            const e = this.elRef.nativeElement.offsetWidth,
                                n = this.elRef.nativeElement.offsetHeight,
                                r = Math.max(0, Math.min(this.getX(t), e)),
                                s = Math.max(0, Math.min(this.getY(t), n));
                            void 0 !== this.rgX && void 0 !== this.rgY
                                ? this.newValue.emit({
                                      s: r / e,
                                      v: 1 - s / n,
                                      rgX: this.rgX,
                                      rgY: this.rgY,
                                  })
                                : void 0 === this.rgX && void 0 !== this.rgY
                                ? this.newValue.emit({
                                      v: s / n,
                                      rgY: this.rgY,
                                  })
                                : void 0 !== this.rgX &&
                                  void 0 === this.rgY &&
                                  this.newValue.emit({
                                      v: r / e,
                                      rgX: this.rgX,
                                  });
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(Ro(Ma));
                        }),
                        (t.ɵdir = Ht({
                            type: t,
                            selectors: [["", "slider", ""]],
                            hostBindings: function (t, e) {
                                1 & t &&
                                    qo("mousedown", function (t) {
                                        return e.mouseDown(t);
                                    })("touchstart", function (t) {
                                        return e.touchStart(t);
                                    });
                            },
                            inputs: {
                                rgX: "rgX",
                                rgY: "rgY",
                                slider: "slider",
                            },
                            outputs: {
                                dragEnd: "dragEnd",
                                dragStart: "dragStart",
                                newValue: "newValue",
                            },
                        })),
                        t
                    );
                })();
            class Qp {
                constructor(t, e, n, r) {
                    (this.h = t), (this.s = e), (this.v = n), (this.a = r);
                }
            }
            class $p {
                constructor(t, e, n, r) {
                    (this.h = t), (this.s = e), (this.v = n), (this.a = r);
                }
            }
            let tf = (() => {
                    class t {
                        constructor() {
                            this.active = null;
                        }
                        setActive(t) {
                            this.active &&
                                this.active !== t &&
                                "inline" !== this.active.cpDialogDisplay &&
                                this.active.closeDialog(),
                                (this.active = t);
                        }
                        hsva2hsla(t) {
                            const e = t.h,
                                n = t.s,
                                r = t.v,
                                s = t.a;
                            if (0 === r) return new Yp(e, 0, 0, s);
                            if (0 === n && 1 === r) return new Yp(e, 1, 1, s);
                            {
                                const t = (r * (2 - n)) / 2;
                                return new Yp(
                                    e,
                                    (r * n) / (1 - Math.abs(2 * t - 1)),
                                    t,
                                    s
                                );
                            }
                        }
                        hsla2hsva(t) {
                            const e = Math.min(t.h, 1),
                                n = Math.min(t.s, 1),
                                r = Math.min(t.l, 1),
                                s = Math.min(t.a, 1);
                            if (0 === r) return new Zp(e, 0, 0, s);
                            {
                                const t =
                                    r + (n * (1 - Math.abs(2 * r - 1))) / 2;
                                return new Zp(e, (2 * (t - r)) / t, t, s);
                            }
                        }
                        hsvaToRgba(t) {
                            let e, n, r;
                            const s = t.h,
                                i = t.s,
                                o = t.v,
                                a = t.a,
                                l = Math.floor(6 * s),
                                c = 6 * s - l,
                                u = o * (1 - i),
                                h = o * (1 - c * i),
                                d = o * (1 - (1 - c) * i);
                            switch (l % 6) {
                                case 0:
                                    (e = o), (n = d), (r = u);
                                    break;
                                case 1:
                                    (e = h), (n = o), (r = u);
                                    break;
                                case 2:
                                    (e = u), (n = o), (r = d);
                                    break;
                                case 3:
                                    (e = u), (n = h), (r = o);
                                    break;
                                case 4:
                                    (e = d), (n = u), (r = o);
                                    break;
                                case 5:
                                    (e = o), (n = u), (r = h);
                                    break;
                                default:
                                    (e = 0), (n = 0), (r = 0);
                            }
                            return new Up(e, n, r, a);
                        }
                        cmykToRgb(t) {
                            return new Up(
                                (1 - t.c) * (1 - t.k),
                                (1 - t.m) * (1 - t.k),
                                (1 - t.y) * (1 - t.k),
                                t.a
                            );
                        }
                        rgbaToCmyk(t) {
                            const e = 1 - Math.max(t.r, t.g, t.b);
                            return 1 === e
                                ? new Gp(0, 0, 0, 1, t.a)
                                : new Gp(
                                      (1 - t.r - e) / (1 - e),
                                      (1 - t.g - e) / (1 - e),
                                      (1 - t.b - e) / (1 - e),
                                      e,
                                      t.a
                                  );
                        }
                        rgbaToHsva(t) {
                            let e, n;
                            const r = Math.min(t.r, 1),
                                s = Math.min(t.g, 1),
                                i = Math.min(t.b, 1),
                                o = Math.min(t.a, 1),
                                a = Math.max(r, s, i),
                                l = Math.min(r, s, i),
                                c = a,
                                u = a - l;
                            if (((n = 0 === a ? 0 : u / a), a === l)) e = 0;
                            else {
                                switch (a) {
                                    case r:
                                        e = (s - i) / u + (s < i ? 6 : 0);
                                        break;
                                    case s:
                                        e = (i - r) / u + 2;
                                        break;
                                    case i:
                                        e = (r - s) / u + 4;
                                        break;
                                    default:
                                        e = 0;
                                }
                                e /= 6;
                            }
                            return new Zp(e, n, c, o);
                        }
                        rgbaToHex(t, e) {
                            let n =
                                "#" +
                                ((1 << 24) | (t.r << 16) | (t.g << 8) | t.b)
                                    .toString(16)
                                    .substr(1);
                            return (
                                e &&
                                    (n += (256 | Math.round(255 * t.a))
                                        .toString(16)
                                        .substr(1)),
                                n
                            );
                        }
                        normalizeCMYK(t) {
                            return new Gp(
                                t.c / 100,
                                t.m / 100,
                                t.y / 100,
                                t.k / 100,
                                t.a
                            );
                        }
                        denormalizeCMYK(t) {
                            return new Gp(
                                Math.floor(100 * t.c),
                                Math.floor(100 * t.m),
                                Math.floor(100 * t.y),
                                Math.floor(100 * t.k),
                                t.a
                            );
                        }
                        denormalizeRGBA(t) {
                            return new Up(
                                Math.round(255 * t.r),
                                Math.round(255 * t.g),
                                Math.round(255 * t.b),
                                t.a
                            );
                        }
                        stringToHsva(t = "", e = !1) {
                            let n = null;
                            t = (t || "").toLowerCase();
                            const r = [
                                {
                                    re: /(rgb)a?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*%?,\s*(\d{1,3})\s*%?(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                                    parse: function (t) {
                                        return new Up(
                                            parseInt(t[2], 10) / 255,
                                            parseInt(t[3], 10) / 255,
                                            parseInt(t[4], 10) / 255,
                                            isNaN(parseFloat(t[5]))
                                                ? 1
                                                : parseFloat(t[5])
                                        );
                                    },
                                },
                                {
                                    re: /(hsl)a?\(\s*(\d{1,3})\s*,\s*(\d{1,3})%\s*,\s*(\d{1,3})%\s*(?:,\s*(\d+(?:\.\d+)?)\s*)?\)/,
                                    parse: function (t) {
                                        return new Yp(
                                            parseInt(t[2], 10) / 360,
                                            parseInt(t[3], 10) / 100,
                                            parseInt(t[4], 10) / 100,
                                            isNaN(parseFloat(t[5]))
                                                ? 1
                                                : parseFloat(t[5])
                                        );
                                    },
                                },
                            ];
                            r.push(
                                e
                                    ? {
                                          re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})?$/,
                                          parse: function (t) {
                                              return new Up(
                                                  parseInt(t[1], 16) / 255,
                                                  parseInt(t[2], 16) / 255,
                                                  parseInt(t[3], 16) / 255,
                                                  parseInt(t[4] || "FF", 16) /
                                                      255
                                              );
                                          },
                                      }
                                    : {
                                          re: /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})$/,
                                          parse: function (t) {
                                              return new Up(
                                                  parseInt(t[1], 16) / 255,
                                                  parseInt(t[2], 16) / 255,
                                                  parseInt(t[3], 16) / 255,
                                                  1
                                              );
                                          },
                                      }
                            ),
                                r.push({
                                    re: /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])$/,
                                    parse: function (t) {
                                        return new Up(
                                            parseInt(t[1] + t[1], 16) / 255,
                                            parseInt(t[2] + t[2], 16) / 255,
                                            parseInt(t[3] + t[3], 16) / 255,
                                            1
                                        );
                                    },
                                });
                            for (const s in r)
                                if (r.hasOwnProperty(s)) {
                                    const e = r[s],
                                        i = e.re.exec(t),
                                        o = i && e.parse(i);
                                    if (o)
                                        return (
                                            o instanceof Up
                                                ? (n = this.rgbaToHsva(o))
                                                : o instanceof Yp &&
                                                  (n = this.hsla2hsva(o)),
                                            n
                                        );
                                }
                            return n;
                        }
                        outputFormat(t, e, n) {
                            switch (
                                ("auto" === e && (e = t.a < 1 ? "rgba" : "hex"),
                                e)
                            ) {
                                case "hsla":
                                    const e = this.hsva2hsla(t),
                                        r = new Yp(
                                            Math.round(360 * e.h),
                                            Math.round(100 * e.s),
                                            Math.round(100 * e.l),
                                            Math.round(100 * e.a) / 100
                                        );
                                    return t.a < 1 || "always" === n
                                        ? "hsla(" +
                                              r.h +
                                              "," +
                                              r.s +
                                              "%," +
                                              r.l +
                                              "%," +
                                              r.a +
                                              ")"
                                        : "hsl(" +
                                              r.h +
                                              "," +
                                              r.s +
                                              "%," +
                                              r.l +
                                              "%)";
                                case "rgba":
                                    const s = this.denormalizeRGBA(
                                        this.hsvaToRgba(t)
                                    );
                                    return t.a < 1 || "always" === n
                                        ? "rgba(" +
                                              s.r +
                                              "," +
                                              s.g +
                                              "," +
                                              s.b +
                                              "," +
                                              Math.round(100 * s.a) / 100 +
                                              ")"
                                        : "rgb(" +
                                              s.r +
                                              "," +
                                              s.g +
                                              "," +
                                              s.b +
                                              ")";
                                default:
                                    const i = "always" === n || "forced" === n;
                                    return this.rgbaToHex(
                                        this.denormalizeRGBA(
                                            this.hsvaToRgba(t)
                                        ),
                                        i
                                    );
                            }
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵprov = st({ token: t, factory: t.ɵfac })),
                        t
                    );
                })(),
                ef = (() => {
                    class t {
                        constructor(t, e, n) {
                            (this.elRef = t),
                                (this.cdRef = e),
                                (this.service = n),
                                (this.isIE10 = !1),
                                (this.dialogArrowSize = 10),
                                (this.dialogArrowOffset = 15),
                                (this.dialogInputFields = [
                                    Wp.HEX,
                                    Wp.RGBA,
                                    Wp.HSLA,
                                    Wp.CMYK,
                                ]),
                                (this.useRootViewContainer = !1);
                        }
                        handleEsc(t) {
                            this.show &&
                                "popup" === this.cpDialogDisplay &&
                                this.onCancelColor(t);
                        }
                        handleEnter(t) {
                            this.show &&
                                "popup" === this.cpDialogDisplay &&
                                this.onAcceptColor(t);
                        }
                        ngOnInit() {
                            (this.slider = new Qp(0, 0, 0, 0)),
                                (this.sliderDimMax = new $p(
                                    this.hueSlider.nativeElement.offsetWidth ||
                                        140,
                                    this.cpWidth,
                                    130,
                                    this.alphaSlider.nativeElement
                                        .offsetWidth || 140
                                )),
                                (this.format = this.cpCmykEnabled
                                    ? Wp.CMYK
                                    : "rgba" === this.cpOutputFormat
                                    ? Wp.RGBA
                                    : "hsla" === this.cpOutputFormat
                                    ? Wp.HSLA
                                    : Wp.HEX),
                                (this.listenerMouseDown = (t) => {
                                    this.onMouseDown(t);
                                }),
                                (this.listenerResize = () => {
                                    this.onResize();
                                }),
                                this.openDialog(this.initialColor, !1);
                        }
                        ngOnDestroy() {
                            this.closeDialog();
                        }
                        ngAfterViewInit() {
                            (230 === this.cpWidth &&
                                "inline" !== this.cpDialogDisplay) ||
                                ((this.sliderDimMax = new $p(
                                    this.hueSlider.nativeElement.offsetWidth ||
                                        140,
                                    this.cpWidth,
                                    130,
                                    this.alphaSlider.nativeElement
                                        .offsetWidth || 140
                                )),
                                this.updateColorPicker(!1),
                                this.cdRef.detectChanges());
                        }
                        openDialog(t, e = !0) {
                            this.service.setActive(this),
                                this.width ||
                                    (this.cpWidth =
                                        this.directiveElementRef.nativeElement.offsetWidth),
                                this.height || (this.height = 320),
                                this.setInitialColor(t),
                                this.setColorFromString(t, e),
                                this.openColorPicker();
                        }
                        closeDialog() {
                            this.closeColorPicker();
                        }
                        setupDialog(
                            t,
                            e,
                            n,
                            r,
                            s,
                            i,
                            o,
                            a,
                            l,
                            c,
                            u,
                            h,
                            d,
                            p,
                            f,
                            g,
                            m,
                            y,
                            v,
                            b,
                            w,
                            C,
                            x,
                            _,
                            k,
                            A,
                            E,
                            I,
                            T,
                            S,
                            O,
                            M,
                            P,
                            R,
                            N,
                            D
                        ) {
                            this.setInitialColor(n),
                                this.setColorMode(a),
                                (this.isIE10 =
                                    10 ===
                                    (function () {
                                        let t = "";
                                        "undefined" != typeof navigator &&
                                            (t =
                                                navigator.userAgent.toLowerCase());
                                        const e = t.indexOf("msie ");
                                        return (
                                            e > 0 &&
                                            parseInt(
                                                t.substring(
                                                    e + 5,
                                                    t.indexOf(".", e)
                                                ),
                                                10
                                            )
                                        );
                                    })()),
                                (this.directiveInstance = t),
                                (this.directiveElementRef = e),
                                (this.cpDisableInput = h),
                                (this.cpCmykEnabled = l),
                                (this.cpAlphaChannel = c),
                                (this.cpOutputFormat = u),
                                (this.cpDialogDisplay = i),
                                (this.cpIgnoredElements = d),
                                (this.cpSaveClickOutside = p),
                                (this.cpCloseClickOutside = f),
                                (this.useRootViewContainer = g),
                                (this.width = this.cpWidth = parseInt(r, 10)),
                                (this.height = this.cpHeight = parseInt(s, 10)),
                                (this.cpPosition = m),
                                (this.cpPositionOffset = parseInt(y, 10)),
                                (this.cpOKButton = A),
                                (this.cpOKButtonText = I),
                                (this.cpOKButtonClass = E),
                                (this.cpCancelButton = T),
                                (this.cpCancelButtonText = O),
                                (this.cpCancelButtonClass = S),
                                (this.fallbackColor = o || "#fff"),
                                this.setPresetConfig(b, w),
                                (this.cpPresetColorsClass = C),
                                (this.cpMaxPresetColorsLength = x),
                                (this.cpPresetEmptyMessage = _),
                                (this.cpPresetEmptyMessageClass = k),
                                (this.cpAddColorButton = M),
                                (this.cpAddColorButtonText = R),
                                (this.cpAddColorButtonClass = P),
                                (this.cpRemoveColorButtonClass = N),
                                (this.cpTriggerElement = D),
                                v || (this.dialogArrowOffset = 0),
                                "inline" === i &&
                                    ((this.dialogArrowSize = 0),
                                    (this.dialogArrowOffset = 0)),
                                "hex" === u &&
                                    "always" !== c &&
                                    "forced" !== c &&
                                    (this.cpAlphaChannel = "disabled");
                        }
                        setColorMode(t) {
                            switch (t.toString().toUpperCase()) {
                                case "1":
                                case "C":
                                case "COLOR":
                                    this.cpColorMode = 1;
                                    break;
                                case "2":
                                case "G":
                                case "GRAYSCALE":
                                    this.cpColorMode = 2;
                                    break;
                                case "3":
                                case "P":
                                case "PRESETS":
                                    this.cpColorMode = 3;
                                    break;
                                default:
                                    this.cpColorMode = 1;
                            }
                        }
                        setInitialColor(t) {
                            this.initialColor = t;
                        }
                        setPresetConfig(t, e) {
                            (this.cpPresetLabel = t), (this.cpPresetColors = e);
                        }
                        setColorFromString(t, e = !0, n = !0) {
                            let r;
                            "always" === this.cpAlphaChannel ||
                            "forced" === this.cpAlphaChannel
                                ? ((r = this.service.stringToHsva(t, !0)),
                                  r ||
                                      this.hsva ||
                                      (r = this.service.stringToHsva(t, !1)))
                                : (r = this.service.stringToHsva(t, !1)),
                                r ||
                                    this.hsva ||
                                    (r = this.service.stringToHsva(
                                        this.fallbackColor,
                                        !1
                                    )),
                                r &&
                                    ((this.hsva = r),
                                    (this.sliderH = this.hsva.h),
                                    "hex" === this.cpOutputFormat &&
                                        "disabled" === this.cpAlphaChannel &&
                                        (this.hsva.a = 1),
                                    this.updateColorPicker(e, n));
                        }
                        onResize() {
                            "fixed" === this.position
                                ? this.setDialogPosition()
                                : "inline" !== this.cpDialogDisplay &&
                                  this.closeColorPicker();
                        }
                        onDragEnd(t) {
                            this.directiveInstance.sliderDragEnd({
                                slider: t,
                                color: this.outputColor,
                            });
                        }
                        onDragStart(t) {
                            this.directiveInstance.sliderDragStart({
                                slider: t,
                                color: this.outputColor,
                            });
                        }
                        onMouseDown(t) {
                            !this.show ||
                                this.isIE10 ||
                                "popup" !== this.cpDialogDisplay ||
                                t.target ===
                                    this.directiveElementRef.nativeElement ||
                                this.isDescendant(
                                    this.elRef.nativeElement,
                                    t.target
                                ) ||
                                this.isDescendant(
                                    this.directiveElementRef.nativeElement,
                                    t.target
                                ) ||
                                0 !==
                                    this.cpIgnoredElements.filter(
                                        (e) => e === t.target
                                    ).length ||
                                (this.cpSaveClickOutside
                                    ? this.directiveInstance.colorSelected(
                                          this.outputColor
                                      )
                                    : ((this.hsva = null),
                                      this.setColorFromString(
                                          this.initialColor,
                                          !1
                                      ),
                                      this.cpCmykEnabled &&
                                          this.directiveInstance.cmykChanged(
                                              this.cmykColor
                                          ),
                                      this.directiveInstance.colorChanged(
                                          this.initialColor
                                      ),
                                      this.directiveInstance.colorCanceled()),
                                this.cpCloseClickOutside &&
                                    this.closeColorPicker());
                        }
                        onAcceptColor(t) {
                            t.stopPropagation(),
                                this.outputColor &&
                                    this.directiveInstance.colorSelected(
                                        this.outputColor
                                    ),
                                "popup" === this.cpDialogDisplay &&
                                    this.closeColorPicker();
                        }
                        onCancelColor(t) {
                            (this.hsva = null),
                                t.stopPropagation(),
                                this.directiveInstance.colorCanceled(),
                                this.setColorFromString(this.initialColor, !0),
                                "popup" === this.cpDialogDisplay &&
                                    (this.cpCmykEnabled &&
                                        this.directiveInstance.cmykChanged(
                                            this.cmykColor
                                        ),
                                    this.directiveInstance.colorChanged(
                                        this.initialColor,
                                        !0
                                    ),
                                    this.closeColorPicker());
                        }
                        onFormatToggle(t) {
                            const e =
                                    this.dialogInputFields.length -
                                    (this.cpCmykEnabled ? 0 : 1),
                                n =
                                    (((this.dialogInputFields.indexOf(
                                        this.format
                                    ) +
                                        t) %
                                        e) +
                                        e) %
                                    e;
                            this.format = this.dialogInputFields[n];
                        }
                        onColorChange(t) {
                            (this.hsva.s = t.s / t.rgX),
                                (this.hsva.v = t.v / t.rgY),
                                this.updateColorPicker(),
                                this.directiveInstance.sliderChanged({
                                    slider: "lightness",
                                    value: this.hsva.v,
                                    color: this.outputColor,
                                }),
                                this.directiveInstance.sliderChanged({
                                    slider: "saturation",
                                    value: this.hsva.s,
                                    color: this.outputColor,
                                });
                        }
                        onHueChange(t) {
                            (this.hsva.h = t.v / t.rgX),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker(),
                                this.directiveInstance.sliderChanged({
                                    slider: "hue",
                                    value: this.hsva.h,
                                    color: this.outputColor,
                                });
                        }
                        onValueChange(t) {
                            (this.hsva.v = t.v / t.rgX),
                                this.updateColorPicker(),
                                this.directiveInstance.sliderChanged({
                                    slider: "value",
                                    value: this.hsva.v,
                                    color: this.outputColor,
                                });
                        }
                        onAlphaChange(t) {
                            (this.hsva.a = t.v / t.rgX),
                                this.updateColorPicker(),
                                this.directiveInstance.sliderChanged({
                                    slider: "alpha",
                                    value: this.hsva.a,
                                    color: this.outputColor,
                                });
                        }
                        onHexInput(t) {
                            if (null === t) this.updateColorPicker();
                            else {
                                t && "#" !== t[0] && (t = "#" + t);
                                let e = /^#([a-f0-9]{3}|[a-f0-9]{6})$/gi;
                                "always" === this.cpAlphaChannel &&
                                    (e =
                                        /^#([a-f0-9]{3}|[a-f0-9]{6}|[a-f0-9]{8})$/gi);
                                const n = e.test(t);
                                n &&
                                    (t.length < 5 &&
                                        (t =
                                            "#" +
                                            t
                                                .substring(1)
                                                .split("")
                                                .map((t) => t + t)
                                                .join("")),
                                    "forced" === this.cpAlphaChannel &&
                                        (t += Math.round(
                                            255 * this.hsva.a
                                        ).toString(16)),
                                    this.setColorFromString(t, !0, !1)),
                                    this.directiveInstance.inputChanged({
                                        input: "hex",
                                        valid: n,
                                        value: t,
                                        color: this.outputColor,
                                    });
                            }
                        }
                        onRedInput(t) {
                            const e = this.service.hsvaToRgba(this.hsva),
                                n = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            n &&
                                ((e.r = t.v / t.rg),
                                (this.hsva = this.service.rgbaToHsva(e)),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "red",
                                    valid: n,
                                    value: e.r,
                                    color: this.outputColor,
                                });
                        }
                        onBlueInput(t) {
                            const e = this.service.hsvaToRgba(this.hsva),
                                n = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            n &&
                                ((e.b = t.v / t.rg),
                                (this.hsva = this.service.rgbaToHsva(e)),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "blue",
                                    valid: n,
                                    value: e.b,
                                    color: this.outputColor,
                                });
                        }
                        onGreenInput(t) {
                            const e = this.service.hsvaToRgba(this.hsva),
                                n = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            n &&
                                ((e.g = t.v / t.rg),
                                (this.hsva = this.service.rgbaToHsva(e)),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "green",
                                    valid: n,
                                    value: e.g,
                                    color: this.outputColor,
                                });
                        }
                        onHueInput(t) {
                            const e = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            e &&
                                ((this.hsva.h = t.v / t.rg),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "hue",
                                    valid: e,
                                    value: this.hsva.h,
                                    color: this.outputColor,
                                });
                        }
                        onValueInput(t) {
                            const e = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            e &&
                                ((this.hsva.v = t.v / t.rg),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "value",
                                    valid: e,
                                    value: this.hsva.v,
                                    color: this.outputColor,
                                });
                        }
                        onAlphaInput(t) {
                            const e = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            e &&
                                ((this.hsva.a = t.v / t.rg),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "alpha",
                                    valid: e,
                                    value: this.hsva.a,
                                    color: this.outputColor,
                                });
                        }
                        onLightnessInput(t) {
                            const e = this.service.hsva2hsla(this.hsva),
                                n = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            n &&
                                ((e.l = t.v / t.rg),
                                (this.hsva = this.service.hsla2hsva(e)),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "lightness",
                                    valid: n,
                                    value: e.l,
                                    color: this.outputColor,
                                });
                        }
                        onSaturationInput(t) {
                            const e = this.service.hsva2hsla(this.hsva),
                                n = !isNaN(t.v) && t.v >= 0 && t.v <= t.rg;
                            n &&
                                ((e.s = t.v / t.rg),
                                (this.hsva = this.service.hsla2hsva(e)),
                                (this.sliderH = this.hsva.h),
                                this.updateColorPicker()),
                                this.directiveInstance.inputChanged({
                                    input: "saturation",
                                    valid: n,
                                    value: e.s,
                                    color: this.outputColor,
                                });
                        }
                        onCyanInput(t) {
                            !isNaN(t.v) &&
                                t.v >= 0 &&
                                t.v <= t.rg &&
                                ((this.cmyk.c = t.v),
                                this.updateColorPicker(!1, !0, !0)),
                                this.directiveInstance.inputChanged({
                                    input: "cyan",
                                    valid: !0,
                                    value: this.cmyk.c,
                                    color: this.outputColor,
                                });
                        }
                        onMagentaInput(t) {
                            !isNaN(t.v) &&
                                t.v >= 0 &&
                                t.v <= t.rg &&
                                ((this.cmyk.m = t.v),
                                this.updateColorPicker(!1, !0, !0)),
                                this.directiveInstance.inputChanged({
                                    input: "magenta",
                                    valid: !0,
                                    value: this.cmyk.m,
                                    color: this.outputColor,
                                });
                        }
                        onYellowInput(t) {
                            !isNaN(t.v) &&
                                t.v >= 0 &&
                                t.v <= t.rg &&
                                ((this.cmyk.y = t.v),
                                this.updateColorPicker(!1, !0, !0)),
                                this.directiveInstance.inputChanged({
                                    input: "yellow",
                                    valid: !0,
                                    value: this.cmyk.y,
                                    color: this.outputColor,
                                });
                        }
                        onBlackInput(t) {
                            !isNaN(t.v) &&
                                t.v >= 0 &&
                                t.v <= t.rg &&
                                ((this.cmyk.k = t.v),
                                this.updateColorPicker(!1, !0, !0)),
                                this.directiveInstance.inputChanged({
                                    input: "black",
                                    valid: !0,
                                    value: this.cmyk.k,
                                    color: this.outputColor,
                                });
                        }
                        onAddPresetColor(t, e) {
                            t.stopPropagation(),
                                this.cpPresetColors.filter((t) => t === e)
                                    .length ||
                                    ((this.cpPresetColors =
                                        this.cpPresetColors.concat(e)),
                                    this.directiveInstance.presetColorsChanged(
                                        this.cpPresetColors
                                    ));
                        }
                        onRemovePresetColor(t, e) {
                            t.stopPropagation(),
                                (this.cpPresetColors =
                                    this.cpPresetColors.filter((t) => t !== e)),
                                this.directiveInstance.presetColorsChanged(
                                    this.cpPresetColors
                                );
                        }
                        openColorPicker() {
                            this.show ||
                                ((this.show = !0),
                                (this.hidden = !0),
                                setTimeout(() => {
                                    (this.hidden = !1),
                                        this.setDialogPosition(),
                                        this.cdRef.detectChanges();
                                }, 0),
                                this.directiveInstance.stateChanged(!0),
                                this.isIE10 ||
                                    (document.addEventListener(
                                        "mousedown",
                                        this.listenerMouseDown
                                    ),
                                    document.addEventListener(
                                        "touchstart",
                                        this.listenerMouseDown
                                    )),
                                window.addEventListener(
                                    "resize",
                                    this.listenerResize
                                ));
                        }
                        closeColorPicker() {
                            this.show &&
                                ((this.show = !1),
                                this.directiveInstance.stateChanged(!1),
                                this.isIE10 ||
                                    (document.removeEventListener(
                                        "mousedown",
                                        this.listenerMouseDown
                                    ),
                                    document.removeEventListener(
                                        "touchstart",
                                        this.listenerMouseDown
                                    )),
                                window.removeEventListener(
                                    "resize",
                                    this.listenerResize
                                ),
                                this.cdRef.destroyed ||
                                    this.cdRef.detectChanges());
                        }
                        updateColorPicker(t = !0, e = !0, n = !1) {
                            if (this.sliderDimMax) {
                                let r, s, i;
                                2 === this.cpColorMode && (this.hsva.s = 0);
                                const o = this.outputColor;
                                if (
                                    ((s = this.service.hsva2hsla(this.hsva)),
                                    this.cpCmykEnabled
                                        ? (n
                                              ? ((i = this.service.cmykToRgb(
                                                    this.service.normalizeCMYK(
                                                        this.cmyk
                                                    )
                                                )),
                                                (this.hsva =
                                                    this.service.rgbaToHsva(i)))
                                              : ((i = this.service.hsvaToRgba(
                                                    this.hsva
                                                )),
                                                (this.cmyk =
                                                    this.service.denormalizeCMYK(
                                                        this.service.rgbaToCmyk(
                                                            i
                                                        )
                                                    ))),
                                          (i = this.service.denormalizeRGBA(i)),
                                          (this.sliderH = this.hsva.h))
                                        : (i = this.service.denormalizeRGBA(
                                              this.service.hsvaToRgba(this.hsva)
                                          )),
                                    (r = this.service.denormalizeRGBA(
                                        this.service.hsvaToRgba(
                                            new Zp(
                                                this.sliderH || this.hsva.h,
                                                1,
                                                1,
                                                1
                                            )
                                        )
                                    )),
                                    e &&
                                        ((this.hslaText = new Yp(
                                            Math.round(360 * s.h),
                                            Math.round(100 * s.s),
                                            Math.round(100 * s.l),
                                            Math.round(100 * s.a) / 100
                                        )),
                                        (this.rgbaText = new Up(
                                            i.r,
                                            i.g,
                                            i.b,
                                            Math.round(100 * i.a) / 100
                                        )),
                                        this.cpCmykEnabled &&
                                            (this.cmykText = new Gp(
                                                this.cmyk.c,
                                                this.cmyk.m,
                                                this.cmyk.y,
                                                this.cmyk.k,
                                                Math.round(100 * this.cmyk.a) /
                                                    100
                                            )),
                                        (this.hexText = this.service.rgbaToHex(
                                            i,
                                            "always" === this.cpAlphaChannel
                                        )),
                                        (this.hexAlpha = this.rgbaText.a)),
                                    "auto" === this.cpOutputFormat &&
                                        this.format !== Wp.RGBA &&
                                        this.format !== Wp.CMYK &&
                                        this.hsva.a < 1 &&
                                        (this.format =
                                            this.hsva.a < 1 ? Wp.RGBA : Wp.HEX),
                                    (this.hueSliderColor =
                                        "rgb(" +
                                        r.r +
                                        "," +
                                        r.g +
                                        "," +
                                        r.b +
                                        ")"),
                                    (this.alphaSliderColor =
                                        "rgb(" +
                                        i.r +
                                        "," +
                                        i.g +
                                        "," +
                                        i.b +
                                        ")"),
                                    (this.outputColor =
                                        this.service.outputFormat(
                                            this.hsva,
                                            this.cpOutputFormat,
                                            this.cpAlphaChannel
                                        )),
                                    (this.selectedColor =
                                        this.service.outputFormat(
                                            this.hsva,
                                            "rgba",
                                            null
                                        )),
                                    this.format !== Wp.CMYK)
                                )
                                    this.cmykColor = "";
                                else if (
                                    "always" === this.cpAlphaChannel ||
                                    "enabled" === this.cpAlphaChannel ||
                                    "forced" === this.cpAlphaChannel
                                ) {
                                    const t =
                                        Math.round(100 * this.cmyk.a) / 100;
                                    this.cmykColor = `cmyka(${this.cmyk.c},${this.cmyk.m},${this.cmyk.y},${this.cmyk.k},${t})`;
                                } else
                                    this.cmykColor = `cmyk(${this.cmyk.c},${this.cmyk.m},${this.cmyk.y},${this.cmyk.k})`;
                                (this.slider = new Qp(
                                    (this.sliderH || this.hsva.h) *
                                        this.sliderDimMax.h -
                                        8,
                                    this.hsva.s * this.sliderDimMax.s - 8,
                                    (1 - this.hsva.v) * this.sliderDimMax.v - 8,
                                    this.hsva.a * this.sliderDimMax.a - 8
                                )),
                                    t &&
                                        o !== this.outputColor &&
                                        (this.cpCmykEnabled &&
                                            this.directiveInstance.cmykChanged(
                                                this.cmykColor
                                            ),
                                        this.directiveInstance.colorChanged(
                                            this.outputColor
                                        ));
                            }
                        }
                        setDialogPosition() {
                            if ("inline" === this.cpDialogDisplay)
                                this.position = "relative";
                            else {
                                let t,
                                    e = "static",
                                    n = "",
                                    r = null,
                                    s = null,
                                    i =
                                        this.directiveElementRef.nativeElement
                                            .parentNode;
                                const o =
                                    this.dialogElement.nativeElement
                                        .offsetHeight;
                                for (; null !== i && "HTML" !== i.tagName; ) {
                                    if (
                                        ((t = window.getComputedStyle(i)),
                                        (e = t.getPropertyValue("position")),
                                        (n = t.getPropertyValue("transform")),
                                        "static" !== e && null === r && (r = i),
                                        n &&
                                            "none" !== n &&
                                            null === s &&
                                            (s = i),
                                        "fixed" === e)
                                    ) {
                                        r = s;
                                        break;
                                    }
                                    i = i.parentNode;
                                }
                                const a = this.createDialogBox(
                                    this.directiveElementRef.nativeElement,
                                    "fixed" !== e
                                );
                                if (
                                    this.useRootViewContainer ||
                                    ("fixed" === e &&
                                        (!r || r instanceof HTMLUnknownElement))
                                )
                                    (this.top = a.top), (this.left = a.left);
                                else {
                                    null === r && (r = i);
                                    const t = this.createDialogBox(
                                        r,
                                        "fixed" !== e
                                    );
                                    (this.top = a.top - t.top),
                                        (this.left = a.left - t.left);
                                }
                                "fixed" === e && (this.position = "fixed");
                                let l = this.cpPosition;
                                "auto" === this.cpPosition &&
                                    (l = (function (t, e) {
                                        let n = "right",
                                            r = "bottom";
                                        const { height: s, width: i } = t,
                                            { top: o, left: a } = e,
                                            l = o + e.height,
                                            c = a + e.width,
                                            u = o - s < 0,
                                            h =
                                                l + s >
                                                (window.innerHeight ||
                                                    document.documentElement
                                                        .clientHeight),
                                            d = a - i < 0,
                                            p =
                                                c + i >
                                                (window.innerWidth ||
                                                    document.documentElement
                                                        .clientWidth);
                                        return (
                                            h && (r = "top"),
                                            u && (r = "bottom"),
                                            d && (n = "right"),
                                            p && (n = "left"),
                                            u && h && d && p
                                                ? [
                                                      "left",
                                                      "right",
                                                      "top",
                                                      "bottom",
                                                  ].reduce((e, n) =>
                                                      t[e] > t[n] ? e : n
                                                  )
                                                : d && p
                                                ? u
                                                    ? "bottom"
                                                    : h || o > l
                                                    ? "top"
                                                    : "bottom"
                                                : u && h
                                                ? d
                                                    ? "right"
                                                    : p || a > c
                                                    ? "left"
                                                    : "right"
                                                : `${r}-${n}`
                                        );
                                    })(
                                        this.dialogElement.nativeElement.getBoundingClientRect(),
                                        this.cpTriggerElement.nativeElement.getBoundingClientRect()
                                    )),
                                    "top" === l
                                        ? ((this.arrowTop = o - 1),
                                          (this.top -=
                                              o + this.dialogArrowSize),
                                          (this.left +=
                                              (this.cpPositionOffset / 100) *
                                                  a.width -
                                              this.dialogArrowOffset))
                                        : "bottom" === l
                                        ? ((this.top +=
                                              a.height + this.dialogArrowSize),
                                          (this.left +=
                                              (this.cpPositionOffset / 100) *
                                                  a.width -
                                              this.dialogArrowOffset))
                                        : "top-left" === l || "left-top" === l
                                        ? ((this.top -=
                                              o -
                                              a.height +
                                              (a.height *
                                                  this.cpPositionOffset) /
                                                  100),
                                          (this.left -=
                                              this.cpWidth +
                                              this.dialogArrowSize -
                                              2 -
                                              this.dialogArrowOffset))
                                        : "top-right" === l || "right-top" === l
                                        ? ((this.top -=
                                              o -
                                              a.height +
                                              (a.height *
                                                  this.cpPositionOffset) /
                                                  100),
                                          (this.left +=
                                              a.width +
                                              this.dialogArrowSize -
                                              2 -
                                              this.dialogArrowOffset))
                                        : "left" === l ||
                                          "bottom-left" === l ||
                                          "left-bottom" === l
                                        ? ((this.top +=
                                              (a.height *
                                                  this.cpPositionOffset) /
                                                  100 -
                                              this.dialogArrowOffset),
                                          (this.left -=
                                              this.cpWidth +
                                              this.dialogArrowSize -
                                              2))
                                        : ((this.top +=
                                              (a.height *
                                                  this.cpPositionOffset) /
                                                  100 -
                                              this.dialogArrowOffset),
                                          (this.left +=
                                              a.width +
                                              this.dialogArrowSize -
                                              2)),
                                    (this.cpUsePosition = l);
                            }
                        }
                        isDescendant(t, e) {
                            let n = e.parentNode;
                            for (; null !== n; ) {
                                if (n === t) return !0;
                                n = n.parentNode;
                            }
                            return !1;
                        }
                        createDialogBox(t, e) {
                            return {
                                top:
                                    t.getBoundingClientRect().top +
                                    (e ? window.pageYOffset : 0),
                                left:
                                    t.getBoundingClientRect().left +
                                    (e ? window.pageXOffset : 0),
                                width: t.offsetWidth,
                                height: t.offsetHeight,
                            };
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(Ro(Ma), Ro(rl), Ro(tf));
                        }),
                        (t.ɵcmp = Dt({
                            type: t,
                            selectors: [["color-picker"]],
                            viewQuery: function (t, e) {
                                if (
                                    (1 & t && (Ul(gp, 3), Ul(mp, 3), Ul(yp, 3)),
                                    2 & t)
                                ) {
                                    let t;
                                    Wl((t = Zl())) &&
                                        (e.dialogElement = t.first),
                                        Wl((t = Zl())) &&
                                            (e.hueSlider = t.first),
                                        Wl((t = Zl())) &&
                                            (e.alphaSlider = t.first);
                                }
                            },
                            hostBindings: function (t, e) {
                                1 & t &&
                                    qo(
                                        "keyup.esc",
                                        function (t) {
                                            return e.handleEsc(t);
                                        },
                                        !1,
                                        es
                                    )(
                                        "keyup.enter",
                                        function (t) {
                                            return e.handleEnter(t);
                                        },
                                        !1,
                                        es
                                    );
                            },
                            decls: 28,
                            vars: 47,
                            consts: [
                                [1, "color-picker", 3, "click"],
                                ["dialogPopup", ""],
                                [3, "class", "top", 4, "ngIf"],
                                [
                                    "class",
                                    "saturation-lightness",
                                    3,
                                    "slider",
                                    "rgX",
                                    "rgY",
                                    "background-color",
                                    "newValue",
                                    "dragStart",
                                    "dragEnd",
                                    4,
                                    "ngIf",
                                ],
                                [1, "hue-alpha", "box"],
                                [1, "left"],
                                [1, "selected-color-background"],
                                [1, "selected-color"],
                                [
                                    "type",
                                    "button",
                                    3,
                                    "class",
                                    "disabled",
                                    "click",
                                    4,
                                    "ngIf",
                                ],
                                [1, "right"],
                                ["style", "height: 16px;", 4, "ngIf"],
                                [
                                    1,
                                    "hue",
                                    3,
                                    "slider",
                                    "rgX",
                                    "newValue",
                                    "dragStart",
                                    "dragEnd",
                                ],
                                ["hueSlider", ""],
                                [1, "cursor"],
                                [
                                    1,
                                    "value",
                                    3,
                                    "slider",
                                    "rgX",
                                    "newValue",
                                    "dragStart",
                                    "dragEnd",
                                ],
                                ["valueSlider", ""],
                                [
                                    1,
                                    "alpha",
                                    3,
                                    "slider",
                                    "rgX",
                                    "newValue",
                                    "dragStart",
                                    "dragEnd",
                                ],
                                ["alphaSlider", ""],
                                ["class", "cmyk-text", 3, "display", 4, "ngIf"],
                                ["class", "hsla-text", 3, "display", 4, "ngIf"],
                                ["class", "rgba-text", 3, "display", 4, "ngIf"],
                                [
                                    "class",
                                    "hex-text",
                                    3,
                                    "hex-alpha",
                                    "display",
                                    4,
                                    "ngIf",
                                ],
                                ["class", "value-text", 4, "ngIf"],
                                ["class", "type-policy", 4, "ngIf"],
                                ["class", "preset-area", 4, "ngIf"],
                                ["class", "button-area", 4, "ngIf"],
                                [
                                    1,
                                    "saturation-lightness",
                                    3,
                                    "slider",
                                    "rgX",
                                    "rgY",
                                    "newValue",
                                    "dragStart",
                                    "dragEnd",
                                ],
                                ["type", "button", 3, "disabled", "click"],
                                [2, "height", "16px"],
                                [1, "cmyk-text"],
                                [1, "box"],
                                [
                                    "type",
                                    "number",
                                    "pattern",
                                    "[0-9]*",
                                    "min",
                                    "0",
                                    "max",
                                    "100",
                                    3,
                                    "text",
                                    "rg",
                                    "value",
                                    "keyup.enter",
                                    "newValue",
                                ],
                                [
                                    "type",
                                    "number",
                                    "pattern",
                                    "[0-9]+([\\.,][0-9]{1,2})?",
                                    "min",
                                    "0",
                                    "max",
                                    "1",
                                    "step",
                                    "0.1",
                                    3,
                                    "text",
                                    "rg",
                                    "value",
                                    "keyup.enter",
                                    "newValue",
                                    4,
                                    "ngIf",
                                ],
                                [4, "ngIf"],
                                [
                                    "type",
                                    "number",
                                    "pattern",
                                    "[0-9]+([\\.,][0-9]{1,2})?",
                                    "min",
                                    "0",
                                    "max",
                                    "1",
                                    "step",
                                    "0.1",
                                    3,
                                    "text",
                                    "rg",
                                    "value",
                                    "keyup.enter",
                                    "newValue",
                                ],
                                [1, "hsla-text"],
                                [
                                    "type",
                                    "number",
                                    "pattern",
                                    "[0-9]*",
                                    "min",
                                    "0",
                                    "max",
                                    "360",
                                    3,
                                    "text",
                                    "rg",
                                    "value",
                                    "keyup.enter",
                                    "newValue",
                                ],
                                [1, "rgba-text"],
                                [
                                    "type",
                                    "number",
                                    "pattern",
                                    "[0-9]*",
                                    "min",
                                    "0",
                                    "max",
                                    "255",
                                    3,
                                    "text",
                                    "rg",
                                    "value",
                                    "keyup.enter",
                                    "newValue",
                                ],
                                [1, "hex-text"],
                                [
                                    3,
                                    "text",
                                    "value",
                                    "blur",
                                    "keyup.enter",
                                    "newValue",
                                ],
                                [1, "value-text"],
                                [1, "type-policy"],
                                [1, "type-policy-arrow", 3, "click"],
                                [1, "preset-area"],
                                [1, "preset-label"],
                                [3, "class", 4, "ngIf"],
                                [
                                    "class",
                                    "preset-color",
                                    3,
                                    "backgroundColor",
                                    "click",
                                    4,
                                    "ngFor",
                                    "ngForOf",
                                ],
                                [1, "preset-color", 3, "click"],
                                [3, "class", "click", 4, "ngIf"],
                                [3, "click"],
                                [1, "button-area"],
                                [
                                    "type",
                                    "button",
                                    3,
                                    "class",
                                    "click",
                                    4,
                                    "ngIf",
                                ],
                                ["type", "button", 3, "click"],
                            ],
                            template: function (t, e) {
                                1 & t &&
                                    (Vo(0, "div", 0, 1),
                                    qo("click", function (t) {
                                        return t.stopPropagation();
                                    }),
                                    lo(2, vp, 1, 5, "div", 2),
                                    lo(3, bp, 2, 8, "div", 3),
                                    Vo(4, "div", 4),
                                    Vo(5, "div", 5),
                                    jo(6, "div", 6),
                                    jo(7, "div", 7),
                                    lo(8, wp, 2, 5, "button", 8),
                                    Fo(),
                                    Vo(9, "div", 9),
                                    lo(10, Cp, 1, 0, "div", 10),
                                    Vo(11, "div", 11, 12),
                                    qo("newValue", function (t) {
                                        return e.onHueChange(t);
                                    })("dragStart", function () {
                                        return e.onDragStart("hue");
                                    })("dragEnd", function () {
                                        return e.onDragEnd("hue");
                                    }),
                                    jo(13, "div", 13),
                                    Fo(),
                                    Vo(14, "div", 14, 15),
                                    qo("newValue", function (t) {
                                        return e.onValueChange(t);
                                    })("dragStart", function () {
                                        return e.onDragStart("value");
                                    })("dragEnd", function () {
                                        return e.onDragEnd("value");
                                    }),
                                    jo(16, "div", 13),
                                    Fo(),
                                    Vo(17, "div", 16, 17),
                                    qo("newValue", function (t) {
                                        return e.onAlphaChange(t);
                                    })("dragStart", function () {
                                        return e.onDragStart("alpha");
                                    })("dragEnd", function () {
                                        return e.onDragEnd("alpha");
                                    }),
                                    jo(19, "div", 13),
                                    Fo(),
                                    Fo(),
                                    Fo(),
                                    lo(20, kp, 17, 12, "div", 18),
                                    lo(21, Ip, 14, 10, "div", 19),
                                    lo(22, Op, 14, 10, "div", 20),
                                    lo(23, Rp, 8, 7, "div", 21),
                                    lo(24, Dp, 9, 3, "div", 22),
                                    lo(25, Vp, 3, 0, "div", 23),
                                    lo(26, Hp, 6, 3, "div", 24),
                                    lo(27, Kp, 3, 2, "div", 25),
                                    Fo()),
                                    2 & t &&
                                        (ta(
                                            "display",
                                            e.show ? "block" : "none"
                                        )(
                                            "visibility",
                                            e.hidden ? "hidden" : "visible"
                                        )("top", e.top, "px")(
                                            "left",
                                            e.left,
                                            "px"
                                        )("position", e.position)(
                                            "height",
                                            e.cpHeight,
                                            "px"
                                        )("width", e.cpWidth, "px"),
                                        ea("open", e.show),
                                        Hs(2),
                                        No(
                                            "ngIf",
                                            "popup" == e.cpDialogDisplay
                                        ),
                                        Hs(1),
                                        No("ngIf", 1 === (e.cpColorMode || 1)),
                                        Hs(4),
                                        ta("background-color", e.selectedColor),
                                        Hs(1),
                                        No("ngIf", e.cpAddColorButton),
                                        Hs(2),
                                        No(
                                            "ngIf",
                                            "disabled" === e.cpAlphaChannel
                                        ),
                                        Hs(1),
                                        ta(
                                            "display",
                                            1 === (e.cpColorMode || 1)
                                                ? "block"
                                                : "none"
                                        ),
                                        No("rgX", 1),
                                        Hs(2),
                                        ta(
                                            "left",
                                            null == e.slider
                                                ? null
                                                : e.slider.h,
                                            "px"
                                        ),
                                        Hs(1),
                                        ta(
                                            "display",
                                            2 === (e.cpColorMode || 1)
                                                ? "block"
                                                : "none"
                                        ),
                                        No("rgX", 1),
                                        Hs(2),
                                        ta(
                                            "right",
                                            null == e.slider
                                                ? null
                                                : e.slider.v,
                                            "px"
                                        ),
                                        Hs(1),
                                        ta(
                                            "display",
                                            "disabled" === e.cpAlphaChannel
                                                ? "none"
                                                : "block"
                                        )(
                                            "background-color",
                                            e.alphaSliderColor
                                        ),
                                        No("rgX", 1),
                                        Hs(2),
                                        ta(
                                            "left",
                                            null == e.slider
                                                ? null
                                                : e.slider.a,
                                            "px"
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                1 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                1 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                1 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                1 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                2 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            !e.cpDisableInput &&
                                                1 === (e.cpColorMode || 1)
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            (null == e.cpPresetColors
                                                ? null
                                                : e.cpPresetColors.length) ||
                                                e.cpAddColorButton
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            e.cpOKButton || e.cpCancelButton
                                        ));
                            },
                            directives: [Qc, Jp, Xp, Xc],
                            styles: [
                                '.color-picker{-moz-user-select:none;-ms-user-select:none;-webkit-user-select:none;background-color:#fff;border:1px solid #777;cursor:default;height:auto;position:absolute;user-select:none;width:230px;z-index:1000}.color-picker *{box-sizing:border-box;font-size:11px;margin:0}.color-picker input{color:#000;font-size:13px;height:26px;min-width:0;text-align:center;width:0}.color-picker input:-moz-submit-invalid,.color-picker input:-moz-ui-invalid,.color-picker input:invalid{box-shadow:none}.color-picker input::-webkit-inner-spin-button,.color-picker input::-webkit-outer-spin-button{-webkit-appearance:none;margin:0}.color-picker .arrow{border-style:solid;height:0;position:absolute;width:0;z-index:999999}.color-picker .arrow.arrow-top{border-color:#777 transparent transparent;border-width:10px 5px;left:8px}.color-picker .arrow.arrow-bottom{border-color:transparent transparent #777;border-width:10px 5px;left:8px;top:-20px}.color-picker .arrow.arrow-left-top,.color-picker .arrow.arrow-top-left{border-color:transparent transparent transparent #777;border-width:5px 10px;bottom:8px;right:-21px}.color-picker .arrow.arrow-right-top,.color-picker .arrow.arrow-top-right{border-color:transparent #777 transparent transparent;border-width:5px 10px;bottom:8px;left:-20px}.color-picker .arrow.arrow-bottom-left,.color-picker .arrow.arrow-left,.color-picker .arrow.arrow-left-bottom{border-color:transparent transparent transparent #777;border-width:5px 10px;right:-21px;top:8px}.color-picker .arrow.arrow-bottom-right,.color-picker .arrow.arrow-right,.color-picker .arrow.arrow-right-bottom{border-color:transparent #777 transparent transparent;border-width:5px 10px;left:-20px;top:8px}.color-picker .cursor{border:2px solid #222;border-radius:50%;cursor:default;height:16px;position:relative;width:16px}.color-picker .box{display:flex;padding:4px 8px}.color-picker .left{padding:16px 8px;position:relative}.color-picker .right{flex:1 1 auto;padding:12px 8px}.color-picker .button-area{padding:0 16px 16px;text-align:right}.color-picker .button-area button{margin-left:8px}.color-picker .preset-area{padding:4px 15px}.color-picker .preset-area .preset-label{color:#555;font-size:11px;overflow:hidden;padding:4px;text-align:left;text-overflow:ellipsis;white-space:nowrap;width:100%}.color-picker .preset-area .preset-color{border:1px solid #a9a9a9;border-radius:25%;cursor:pointer;display:inline-block;height:18px;margin:4px 6px 8px;position:relative;width:18px}.color-picker .preset-area .preset-empty-message{font-style:italic;margin-bottom:8px;margin-top:4px;min-height:18px;text-align:center}.color-picker .hex-text{font-size:11px;padding:4px 8px;width:100%}.color-picker .hex-text .box{padding:0 24px 8px 8px}.color-picker .hex-text .box div{clear:left;color:#555;flex:1 1 auto;float:left;text-align:center}.color-picker .hex-text .box input{border:1px solid #a9a9a9;flex:1 1 auto;padding:1px}.color-picker .hex-alpha .box div:first-child,.color-picker .hex-alpha .box input:first-child{flex-grow:3;margin-right:8px}.color-picker .cmyk-text,.color-picker .hsla-text,.color-picker .rgba-text,.color-picker .value-text{font-size:11px;padding:4px 8px;width:100%}.color-picker .cmyk-text .box,.color-picker .hsla-text .box,.color-picker .rgba-text .box{padding:0 24px 8px 8px}.color-picker .value-text .box{padding:0 8px 8px}.color-picker .cmyk-text .box div,.color-picker .hsla-text .box div,.color-picker .rgba-text .box div,.color-picker .value-text .box div{color:#555;flex:1 1 auto;margin-right:8px;text-align:center}.color-picker .cmyk-text .box div:last-child,.color-picker .hsla-text .box div:last-child,.color-picker .rgba-text .box div:last-child,.color-picker .value-text .box div:last-child{margin-right:0}.color-picker .cmyk-text .box input,.color-picker .hsla-text .box input,.color-picker .rgba-text .box input,.color-picker .value-text .box input{border:1px solid #a9a9a9;flex:1;float:left;margin:0 8px 0 0;padding:1px}.color-picker .cmyk-text .box input:last-child,.color-picker .hsla-text .box input:last-child,.color-picker .rgba-text .box input:last-child,.color-picker .value-text .box input:last-child{margin-right:0}.color-picker .hue-alpha{align-items:center;margin-bottom:3px}.color-picker .hue{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAAAQCAYAAAD06IYnAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AIWDwkUFWbCCAAAAFxJREFUaN7t0kEKg0AQAME2x83/n2qu5qCgD1iDhCoYdpnbQC9bbY1qVO/jvc6k3ad91s7/7F1/csgPrujuQ17BDYSFsBAWwgJhISyEBcJCWAgLhIWwEBYIi2f7Ar/1TCgFH2X9AAAAAElFTkSuQmCC");direction:ltr}.color-picker .hue,.color-picker .value{background-size:100% 100%;border:none;cursor:pointer;height:16px;margin-bottom:16px;width:100%}.color-picker .value{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAAAQCAYAAAD06IYnAAACTklEQVR42u3SYUcrABhA4U2SkmRJMmWSJklKJiWZZpKUJJskKUmaTFImKZOUzMySpGRmliRNJilJSpKSJEtmSpIpmWmSdO736/6D+x7OP3gUCoWCv1cqlSQlJZGcnExKSgqpqamkpaWRnp5ORkYGmZmZqFQqsrKyyM7OJicnh9zcXNRqNXl5eeTn56PRaCgoKKCwsJCioiK0Wi3FxcWUlJRQWlpKWVkZ5eXlVFRUUFlZiU6no6qqiurqampqaqitraWurg69Xk99fT0GgwGj0UhDQwONjY00NTXR3NxMS0sLra2ttLW10d7ejslkwmw209HRQWdnJ11dXXR3d9PT00Nvby99fX309/czMDDA4OAgFouFoaEhrFYrw8PDjIyMMDo6ytjYGDabjfHxcSYmJpicnGRqagq73c709DQzMzPMzs4yNzfH/Pw8DocDp9OJy+XC7XazsLDA4uIiS0tLLC8vs7KywurqKmtra3g8HrxeLz6fD7/fz/r6OhsbG2xubrK1tcX29jaBQICdnR2CwSC7u7vs7e2xv7/PwcEBh4eHHB0dcXx8zMnJCaenp5ydnXF+fs7FxQWXl5dcXV1xfX3Nzc0Nt7e33N3dEQqFuL+/5+HhgXA4TCQS4fHxkaenJ56fn3l5eeH19ZVoNMrb2xvv7+98fHwQi8WIx+N8fn6SSCT4+vri+/ubn58ffn9/+VcKgSWwBJbAElgCS2AJLIElsASWwBJYAktgCSyBJbAElsASWAJLYAksgSWwBJbAElgCS2AJLIElsP4/WH8AmJ5Z6jHS4h8AAAAASUVORK5CYII=");direction:rtl}.color-picker .alpha{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAAAQCAYAAAD06IYnAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AIWDwYQlZMa3gAAAWVJREFUaN7tmEGO6jAQRCsOArHgBpyAJYGjcGocxAm4A2IHpmoWE0eBH+ezmFlNvU06shJ3W6VEelWMUQAIIF9f6qZpimsA1LYtS2uF51/u27YVAFZVRUkEoGHdPV/sIcbIEIIkUdI/9Xa7neyv61+SWFUVAVCSct00TWn2fv6u3+Ecfd3tXzy/0+nEUu+SPjo/kqzrmiQpScN6v98XewfA8/lMkiLJ2WxGSUopcT6fM6U0NX9/frfbjev1WtfrlZfLhYfDQQHG/AIOlnGwjINlHCxjHCzjYJm/TJWdCwquJXseFFzGwDNNeiKMOJTO8xQdDQaeB29+K9efeLaBo9J7vdvtJj1RjFFjfiv7qv95tjx/7leSQgh93e1ffMeIp6O+YQjho/N791t1XVOSSI7N//K+4/GoxWLBx+PB5/Op5XLJ+/3OlJJWqxU3m83ovv5iGf8KjYNlHCxjHCzjYBkHy5gf5gusvQU7U37jTAAAAABJRU5ErkJggg==");background-size:100% 100%;border:none;cursor:pointer;direction:ltr;height:16px;width:100%}.color-picker .type-policy{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAAgCAYAAAAffCjxAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAACewAAAnsB01CO3AAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAIASURBVEiJ7ZY9axRRFIafsxMStrLQJpAgpBFhi+C9w1YSo00I6RZ/g9vZpBf/QOr4GyRgkSKNSrAadsZqQGwCkuAWyRZJsySwvhZ7N/vhzrgbLH3Ld8597jlzz50zJokyxXH8DqDVar0qi6v8BbItqSGpEcfxdlmsFWXkvX8AfAVWg3UKPEnT9GKujMzsAFgZsVaCN1VTQd77XUnrgE1kv+6935268WRpzrnHZvYRWC7YvC3pRZZl3wozqtVqiyH9IgjAspkd1Gq1xUJQtVrdB9ZKIAOthdg/Qc65LUk7wNIMoCVJO865rYFhkqjX6/d7vV4GPJwBMqofURS5JEk6FYBer/eeYb/Mo9WwFnPOvQbeAvfuAAK4BN4sAJtAG/gJIElmNuiJyba3EGNmZiPeZuEVmVell/Y/6N+CzDn3AXhEOOo7Hv/3BeAz8IzQkMPnJbuPx1wC+yYJ7/0nYIP5S/0FHKdp+rwCEEXRS/rf5Hl1Gtb2M0iSpCOpCZzPATmX1EySpHMLAsiy7MjMDoHrGSDXZnaYZdnRwBh7J91utwmczAA6CbG3GgPleX4jqUH/a1CktqRGnuc3hSCAMB32gKspkCtgb3KCQMmkjeP4WNJThrNNZval1WptTIsv7JtQ4tmIdRa8qSoEpWl6YWZNoAN0zKxZNPehpLSBZv2t+Q0CJ9lLnARQLAAAAABJRU5ErkJggg==");background-position:50%;background-repeat:no-repeat;background-size:8px 16px;height:24px;position:absolute;right:12px;top:218px;width:16px}.color-picker .type-policy .type-policy-arrow{display:block;height:50%;width:100%}.color-picker .selected-color{border:1px solid #a9a9a9;border-radius:50%;height:40px;left:8px;position:absolute;top:16px;width:40px}.color-picker .selected-color-background{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACgAAAAoCAYAAACM/rhtAAAAh0lEQVRYR+2W0QlAMQgD60zdfwOdqa8TmI/wQMr5K0I5bZLIzLOa2nt37VVVbd+dDx5obgCC3KBLwJ2ff4PnVidkf+ucIhw80HQaCLo3DMH3CRK3iFsmAWVl6hPNDwt8EvNE5q+YuEXcMgkonVM6SdyCoEvAnZ8v1Hjx817MilmxSUB5rdLJDycZgUAZUch/AAAAAElFTkSuQmCC");border-radius:50%;height:40px;width:40px}.color-picker .saturation-lightness{background-image:url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOYAAACCCAYAAABSD7T3AAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAAsTAAALEwEAmpwYAAAAB3RJTUUH4AIWDwksPWR6lgAAIABJREFUeNrtnVuT47gRrAHN+P//Or/61Y5wONZ7mZ1u3XAeLMjJZGZVgdKsfc5xR3S0RIIUW+CHzCpc2McYo7XGv3ex7UiZd57rjyzzv+v+33X/R/+3r/f7vR386Y+TvKNcf/wdhTLPcv9qU2wZd74uth0t1821jkIZLPcsI/6nWa4XvutquU0Z85mnx80S/ZzgpnLnOtHNt7/ofx1TKXcSNzN/7qbMQ3ju7rNQmMYYd/4s2j9aa+P+gGaMcZrb1M/tdrvf7/d2v99P9/t93O/3cbvdxu12G9frdVwul3E+n8c///nP+2+//Xb66aefxl//+tfx5z//2YK5Al2rgvf4UsbpdGrB52bAvArXpuzjmiqAVSGz5eDmGYXzhbAZmCrnmzddpUU+8Y1dAOYeXCtDUwVwV7YCGH6uAmyMcZ9l5vkUaBPGMUZ7/J5w/792/fvv9Xq93263dr/fTxPECeME8nK5jM/Pz/HTTz/dv337dvrll1/GP/7xj/G3v/1t/OUvfwkVswongjdOp9PzH3U3D3zmWGnZVXn4jCqs7wC2BKP4/8tAzkZsoWx6XrqeHZymvp4ABCBJhTQwKfDT8gzrZCIqi5AhiACjBfEB2rP8/X63MM7f6/V6v9/v7Xa7bYC83W7jcrlsVHIq5ffv30+//fbb+OWXX8ZPP/00/v73v4+ff/75JSvbeu+bL2WMMaFbAlpBNM85QX+ct6qoSqkPAwuQlBVKqGNFSUOAA3Bmu7gC5hNOd15nSwvAOUW7C4giUCV8Sgn5L9hNFIqTsp0GxI0ysioyjAjkY/tGJVEpz+fz+OWXX+7fv38//f777+Pbt2/j119/HT///PP49ddfx8fHRwrmTjV779EXu2px2xhjwtdJZQcAWQIPLPISsMJaSwiD8gzIKrwSyATE5j5nAbR5c1dBUwBlsEWW0h6LqiYsqFPAQxCyRZ3wOSARxmlXMX5k64pQfvv27f75+dk+Pj5OHx8f4/v37+Pbt2/jt99+G9++fRsfHx/jcrmUFLO31gYDWblxRIs/TqfT7ousxJsAxXA2Gc7TA9XdgfdoHbFsj76X2+1WArgI1ageGwA3qupqoHsmcbI6Fu93quggFa9d7LeDtgKfAFHBJ+NEByIkcJ5KervdTmhhGcgJJSZ5vn//fj+fz+18Pp8+Pz/H5+fnmGD+/vvv4/v37+Pj42N8fn6O2+1Ws7JjjP6wraMI5E4RZ8x2vV5TSwkquotV7/d7Tz6HFWsD/qNcdw0CQ3q/321c686TwDVIdbuy73zNldhSHb8I2klZznm+InBS4U6n0302aBFsLhHDAKJVJVglfI9jhvu53W53sLANYNxAiDA6MCeUHx8f9+v12i6XS7tcLqcZW57P5yeY8/fz83Ocz+fnsSmYUyknWEG85WBst9stzSLyMdfr9Qi08iY15UZ0LlDGLhR3o5zK2j7OPUTD0E+nU3tk7Xb/16NFbhloAMuY1zjLUOO3BKeIDe+Z8s3/J4gFo4TM5jPmuRg28foUKKVSwo16TgA5npywcWLHgYl/Pz8/73/605/ab7/91m63W7tcLie0sZj4mao5gTyfz88E0f1+j8EcYzwTPEG2cqjyfHNF0M8fuqEiaOVnRzZZQNh5fwQyHg/HDGfJo89Q1zb/quu5XC6773I2XKfTqd/v9+d3wuqWva/YTdUdEV3fhIv/Viyps6YE3x3r43K5bJQS66zaxVGFsvd+//j4aF+/fm3fv39vt9utff36tf3+++/tdrudvn37ZuNLBaaCMgUzC+rZRiFowxUuJI8YMqcCp9Opq5vagaYU6lGJA1XQqejchw6Cj0Gw5nYBrGw01A2O206n04BGouNNyTfp/FwElhUey6nXrIKw7QQWddxuN2ldL5fL839gSPF8ahu/JvBO48CPSuqMf8Vp9/P53L58+dLu93s7n8/tfr8/39/v9/b5+TkhPJ3P56mQ436/j+/fv+/iSgbzer0+AZx/5+88bv6OMda6S5z6kd21fYC9dxv7cIJJ2d9AOS30fPMzyHiTM8B4DF6XUlYHp4KQW3W+1t77MNB1vGHxWq7Xa7vf78+y5/N5A+H1et29xuP5dbYtyaRu4AksbPq6936fjRzXRxBbPr/b+b18+fKljTHaBBBfn8/n0/1+H1++fBnn8zm0sB8fH5u4cr5GuBhMVk0EEn9RsctgVhM+ixlJtMA23R8B6yysAstBOgFXIKKCMIgToMqNEu2fYMH7ztc732dQKkCj1ytAZtY0Kx8pIr8GGJ+AT3V+2Hirhl++fBmXy2Wz73w+b17P8p+fn8/tUwGVleVkTyUb68DkfayWY4zxNRihU4EpLJPZVrK+u7J4/mgfKqeLW9X2REWlItL1diynbDDb3+jXgYjQqn0rrxWc+NkILP7F7xIbMvx7vV53x40xnlbWJF12ZSag/N0pW6t+ZzmOMzHjajKwDfond78zYTdfq18up97zr2q8v3IioBprRtBl0EZ9og5WBRGOdOHjIjXF7UotFbgOWnXzIJyzYvjG5IYgsmMOxHkz8OsMSrVNWeq5T8DaOcbEv1Od5rbs9aO7YvMet63EkF++fMExq+MRl4/L5bLZN/+ez+fnZ6KazuMqXSQVO5spJXflHAIzes/xJseckRJiDMog9d6VfRrqXMr6KpVV27jRwJacGovOAM1zMdQMnwK1AubK63kdCChvI1C7g0z9nf/D+Xze2Vj8H7Gx4P9duQlsYCrqyN8XqG3Hm/10Oj3jw/n+crlstuM+jPmmxT2dTuPz83Pzt2pn1XsEHX/bnPaVqVmh0xwOt0o6XLLAHePUU203wHfcrspCwmV3TryB5s0Mseeg97x/BwzCjBlbB+pRAPla0BVQuT6V6QHdBlj3d0KG147b+DqxQeUymDO43W4dQar+TIjwmAd0z8/h65vf0/yLv3Pb5XLpru/ydDo9s7ET0I+Pj6dKK9VUEIeKWQWPAOrJ8LKd4vE+t91Y3e7UFlWatg2VwJnb+HPmtvm/sfK59/OaWF3x/eP1UPHvA5DDYDpYXfb0drv1V2DkBkxtw/tEWVVlXWdC9pFYs5/jfh9dS/16vW7s6lTG+TfqsxSJHxkXXq/Xdr1eu4LsfD6P3vsT3N77DkL+zPm5jSdKL4zR3AxQd6rHkLkYlSowsrq7znzu6wSwdsMJOXmA5fBcjxtgMGBYHlr5zokhtsMCTgXLQOW4XC6dEyEMprL8mAQzXRgduix2yZzorxkYsDn3hB1VeMLGsXsVtgl2pW8S3svk0vw7R4hNaHvv4cACl5HFzwIH0Kc6zu4XjDPR/jpAVxWzO1Xk2DDb3vTcxeGU1iWZHkmIDWziWKvirCJ4Dravs6IJ/GG6cTqWdXDy+fArQDVVkLqkVjAoZIITdmmIqXwqa95N3+MGYoZQdRVNO53Y1xRkhO16vY7eu507Ca9lJnbGpxOemQhSw/AQsmmp5zU9BiU8G6wvX76M6/U6Pj4+do0Bz4CpgiknTUeDqwlKBmg3u4OVjrZ1A+rAcgaejWq6eJCvCYFDONSwOgHX4EQRw8lxbzDOdEK6gZ3Hk1b+8g2o1JFtKXyv/fEdTXuWjWXdAZiBp6ADeDrCFiim7B6ZFneeI7Gvm/PMkUDX67W7xI8b0D7/v8dA9qfN5oaCf74WZjH0mf1cmfY1Y0JUFmVrTWu8uzkNcLtEj7u5FXBTkfC6GOA5q8YMxO8KVvF6sAVGdcrUbsKODcQKkLMOMdmlxum642YrPm26AlhZW1YB1R+rrGswE8TaYAWeUMxdf+WjwSvZ2Ef3ytOyfn5+PpVPAaqOn43MtNBqvmjjxbjM4lZjZY4gqNMI5ktaW/sYKNwS+9lFQzGihmMCKPa7+Z0V6Eb0GRmobtpX8JljWu5FMLN5ja6hG9kwQgZqf5+1NH5UxzkFReCdWhJ8XdlGUkxO7HRlYRm4mVO43W7ter12TPJEw/rmEN3L5SKHIWZg9mz+pUoKOYq5bJTJdX2gme1UcxMZQFaEQIlHct32M+Y1BzGkGuzfiyAN9z+ugplZ1symCrDCYYkGxDTpI9RzBy0rHyeDUC1nWaeUaD9n4xkNyYMBDZtzZ3B++fJlY21XFDOcARJlabOyiS3uCpLI9jrZjCDkaVvcCCjwognKShWdzXZWlZMvVTgD8LpqlCLrqgbcB+qYwrgKYpT0ccCqbKyCValkEabn/FynogCrPKfqf51xJ7sGB2ZXcZmxoSOztjx300DZi7a0/2AIR0UlBag9SuDw6KcAzlaB7vHZvWpjK90dyrq6bKyDUZQbR0B05biLQkHIcSUmgIK+SwuqgHCnoio2RQU1yj+BnBy9pphVKLGyC7ZzFK1pxWK+E8IhVCWLN/uLtnUU4ayoYLoaANz8FdtaSvY4pV0BEW2ls61czqllBKpTyKgMAhrZ1cdc1RROtPmvWNkdcKZ7ZKxaWjiPLJMpp7OZKxA+rqG/oJLjxf0pnJlqLoDZo3gyU0mKGys2taKecj/d1C+rJSplBqlTyAqgR+D8KjKlmRL2gtUcAdCtsL+ijCNT1oqqqkH2OHEbG5sDFnUg5Aa+yLou2VU1ptj1S2ZQqv1ORZN9IWzRfgaRBxKoBE8UWyqlJFtrIc0AxNjSjed99CTY/XDfSzCz5M0IZoVEsWnPFNTsl8ooVC1TzbGgqFZNDSgVwKK+1sGDMKqxZCWGVMDysiEr1jVSQJUYwj5iHOlThdHt44SQg9CN+nl8D90NMIgAdgr46JqRiR9I8vRdFvbr17m/yxUMKjNLMiVUADwu2CWGhhi+F55TWM9M9cogzms1dnM4uOF/LAEYWdcqnM7yFmyq3IfwmOROd7Y1iFWtOjoY8To41mTV5IysgFFuRzsbWFGbNIIJCDv1dOo4lZG7jWBwRFtVTKuWyeCByJKOan8oZ3ep9XddNl0tDuaywLz9cXPYeDAA0SpkBO9sbVcTOVWldPv4uyzEkzxHtjvonHoSkFEWNoo1d8DhcQputd2ppNon4BzoAiJ1hBFQg0dVtdbGHHDQWushmNEQukLM2QO1G2Y8bgTXqFhcBJj7EjPgcPts8US8qPpPB/dXznOh5Z438tzH5ec6QgrOKrRRfKmysBmUDB+PhYabMlVPER+GCSITTzr7am2tArH3bgcEzPJm+cr5jJ4NnHNFDVrFXcI5Le9k5Jnw+bedbV+FfRzZIHaOOaOsLY0/7UGs58DjrGwKMIMFIGzOEW1/jGsdAtCN6hEAI4hBe9YXeRROBSVPAVPAqvIM5bx5hVKWAMP6zBRy3iescridVdFBinBxXDnG2GRY2XbCvp1lhvGtO9Bxu5h908XQu42lnSArMFdizMim8uwRCxPGnnOS8lwpnbOiDqTAjsrRN/PcoAScCbaACqVM40ylnjjTBs+bwWlAG23/UKbdkiwKWIQPGzWaczpoSlxPEj822cNWkpS7FyzsDrqpfgpG3jahw2vgbaSQAxuLWZYt7JzyNe8JoZpNAcvDFOdw0wqYT9AK1rZz/DdbSlLPp0ryIxgQJlK9AZlEq7IOXpohg9PIhrCng88JsOxiV4ZWAYfg4sikx/8ky2Z9l862uqwrfscIH8+ugTmVGyiddeVYUgEMn4GZzg14EwIsh9sx2cKKiWXReuOE5gzGOQgdlRKVVdlevqb279Xq0Qnsts2VDaBO0coezsruWtHApu6sKG4IBhN0aGU2kLrMKGRTN3HmbCDwKV14zvkMEDG4QfZVspVlaNU2mhc5TEZ3N1h/zqTheuLpW05ZWTGVjb3dbnNmxKZBnN8JqidaVLKAOyARNLS+MB54Z2+VaqoMLKroVBlngefnTPAcoHNWCSvlfA8CI0HEmBNBnBlXyMrzU7A7WVm94PPqQ2gmqKx+WDGsnvilmcSOBJqOK1nYyAIzuAyesq3UdSK3KfWcYKD95HmfYOU3qser2CtYEUA+FpfqdNvgPBZUBhDrGONRVlQsh8rLcaUCykHG0OOUwTlLBrsh5soEMGezi1E4HRVt1icp5wZEFXdibCkG8Y8vX75sbO4E0iom9z+hjSiOfy3DhpXItpVhE+UGQdvoWjtChmrGHf4YAzKgBNnGtuJxFCeGdhUAfQLLK8kBYAP6gvFJZajMG3Xkycy8KuC0q4Eyymwtwdxdv2M0mIBtK0LKnf640j00Auq4gUkdWGlhs22qJc6dZCsL19oxnlTJG4SYVRIGpD8TPFBuM6OElbS1pldid4mGAyN6ZIupbC5bXJN9fdpbThSxLUaI8IG1XIYBxW3Tjs6KQosKcxfxcQmdnwRGM10GnFcCy2XYunLMyAkdgk4mePiczsLygthcBut6goOqS7YVFXADLjaosB6s6ofcZWAZSIRYqSUkizYwttYab3vUOQ9w2HRxIIg8WwRVeE68xi4UtL3zRphxplzwuZrcqYCq1I3jPI5dnJIygEohMbPqVJSzrwzxBJTs5zN+ReUSgxikPQVF3JVBeNQxbHENrEMNvEdFZVV9lH9+ORGEsNZQpyTNc4C3AG7XF4ngzq+DrO2zbuaaOXgdaFcdkEotoSFBVX2qJ0C8OWZeG4KGlpghA0XfTOPCqV2qqwQ26QWfF2PMLhI2w1lVAa2aPsYd0za25MQRwgcZN6uQDCi+ZxiD4XEM2kZxOT41FnZnaRlcpZouzlRqqdbQVWopQoSB58RV50lBNrHi/AwXS5LrwDVlpY3Fc3ByiYGc52Trist6kOXdwInAQtJpp5QchyaquYOV7Su+fxVMaV3dc0RE2S6mUY0gLt2pMcYqrKIQ9w2l1gpQUMtQYcmmbt5DTNxdhnUCjQqtbK9SUSzvrC0mmhhE1e2FS2+oxypy/ZASutkmtjx3vcBC24PX65nbqkBCRhfjS9kIYPnee8cMagVOhI/3T1fAmdtAWZsCswTJCkQVNa0qWKSKPOpHAUhD9DrbVcyoYkwqhvh17vYAayXLQyKGYdxlUDFp494rBXRjYgO17DDYetNIUj/ezp6S0lnlpEwsWmJMkOwsKXeZKEAjIHn0EQJISaRBcO6UMINz7p/bEjjnw4ft+xmDvksxX4G2rIris7qaeKwAFMP2Oi7n4criuZwtpSUwpfLxSnORSrIqusc5ZFaXysqRWjiZ2DyAWEIL35tVSoQElFACjOeGGSE7AHEQgdo/LSvCOgGBvkxsmDbvlS3Fp5vhaB2TAGqRKrKKMrhLVpaGzEVjZ0OQxDhaCTA+QyRR1d15aQzrJntL3RibsipjG6jlgL4yqbS0sNYg1e84vhbBVrElK64CUcWYXDfKxhpIuxiVJZUxsbMy/uRBKTNRQ4kQ3LdRYLS0rJjRPlTPqY6gdJsEDc+aQXAn+HgsNUCbRuF0Oj0zwnA7bWDkbhO5Ens00qeQhS1laBMl5M/cAaxsLF8rKyql+Tf7ELLEGu/ixiimdCvo0TjfpjKwaggen4eh5v7LokLKbLuyvHhcZG8dhGrEDx7Hg93ZppJF7qBqO3iVveXEDQNInzeoe8Yq6ePaZBZ2JviM3W2UAGotekRCAGq4EkF1X3DOnR11yRsBL1tRa0PVcZiNFXZ2c34FskvomInQQ6lzpJoZbJxk43NwKJFBquJSsrByHydxKOnTxQASBmS3j+JMnsHSla3Ec6K9VWoJVn9zfjwOM7hqYAAqJQwE2a3nA48J2QGegRkpZNivSY+ys3EkKd4oJIwsvIHl3cWgLt5k4NH6OmtLWdpurOkwEMupYc7eMtDRhOcI2ui5JhVIzXzLyto/GAPuZoyo8wkoduVgJglCt7OhGbgID4Mq4si+63zUS1FuFFXFlqyaj2emHlLMcBqYu0FMuR28BbB7lOxRMSiCQXFhCKuwkhZ+pYDiGSgbsKKV8MiSRsuHSIWM9rklRiIlZZuqXjsQK8ooYJMgq3JKWVkhHbhsVxFUzthOWPkYijcbx54IKsSdT+uLr3crGKyoYgFiGR9iBk4kfloUX+JIlQRQqabmpgnhqtpQpb6RVQ1WH5DnrS4hEoGZqaerQ2dhFbz8XePxShmDbo70eISjoorO2vK8SJXI4SUmEU4zWKDzUDtWTYw7xXlbSTEj4FRg7zKnKoGRALv0Gs9Tgc1BpCywGZRQAtqVz2xrBcAMzEpfZwFSa2G5W0QBFjSMapWAEFa3HcGN7CxDzECyIkJ97qwrqWNTWVo876PPsjPkj2wvgroM5lLZKMETKVql/CvnWVFiFa/SzJUQwkoZsr67Y6vlSRV3/2tmNTOY3vnaxYwMuoPKqdzR1w7IqHymlPxaAThfU7Ko2ZXYj4AYJHL+kNdKwRQYESTRa5fsUZ/rVC1TMTyWVyYoqNtuzaHsMyv2tvoarxdfqwYgU1axFo/cnql1FGsqK+uAROV8BX4GU8WcZTATi2q7Qcyi0O0V+GhWBMNRUkn8H1SsWVE5By3Gi0ECqUeJoBfAtDa4amkdXG37AGP5Ggeb84p7UazpoKRzdFzeQ8HkoHGxprKy/Hpm5t12p47J6xTYDEz7uINEXSuxYXvFskYAc+ySxH9sf5ftKzU6IbwVBcUGg5e5FMCEXSErZR0wGayV19woM9guPjTqJdVTqR4uE4nJnLldWVkECCZLd2VLF+xtamex7IpiriSDUpvrpn9lrwGMCHyppMH+ps6LILsuFGUj1XEOXiqbqSHPUKnClpWV68kqtURVNDY4TNaocykoYeTU5ngGEQa/S1DnnE4AeXMcKjHPAmFVjCBENaeyLVNHfr3px8xUstJ94hIpfH4HKE/eDaArK6lSyVVFbdt1gxTIVk3pppVlFXi4pEhVBTObquohU85MLXn1iahvUkHJjSCMc01tLFveVVBx0DodM6jftCu7DOtIzYxrc0qp1JGP2ayYFz2Gb6HvMrO8cnGtV6Gjm3uImSfD2GpWK6uowbZGMxFKQCo1pOMtcMXFpRst+hXGoAomF3sSTBGgTglbBKWwsQ3tZqaYSp0Z1CimRDWFcCJUPYJ00BI5FkKYNoifuQxmN88SWVXWLMaUqqqgC0BmQJR6sk3u9NCf6jYLXxAfqsYEgVLAhRY2AtgtflZNFmFyhxdrLkAdWlk4D88M2ixHyepIdhMHrG/iR1ZGtq0MGpbDbRPYOXeSY1M6Ny4ZstvGSktK+XbFPATj2D371saPEsAMXhXrsZ0km/XStkhhMyBfsa6uXFZe2VCe+YMr1+GKgwrQyNYq1VRrB+EizAow6NsdNKcyVEkYeM73ys6q4kAHp6BiFklTkIrVC5oYV7uzwOGCz4UJ0Stq2lWMJy4wtb+RetL6tZFicnJmBw5UjCvXXMZVJX2MQkbf+XN5EWd78Vz8/JEsMZTBiKNzsm1inLRUQ74H4NidaqI68j5sAFgxcRveC7ieLJXfQYxjZZ2CsiWFewZXJmBIlZ1tdtrX4hSuateKso/RZOtOKW2nmq1oTzeK6dRWAWu2NRVb4hq0SXm1GvtugHrbr5IXqmSktg5CuDE2MSlPwsY5kNE2Wp3AqiZbWVLAxiBF+2iBZbuNj6MB6rsMLC7FyasaYDyo7KkoPyEtw3pEMXfPvxAJi2jAQQgjrz0rLIZSWZlIoNhwd5xK4AR9mYNjWAaLrnuImJeBVN9zBORObVvbr+mTTfFSEJLSRnHo7hEJoIi8MFqjxmvgmF5URZz4zLFgZZ8Ctu2X7ggVccKm9gVxIsOHqxXgNMKnFWZYnf1dBnOhayXq17QwFlWW09eNKyVJFmXqaONGA5aCegMbJ3UUkGY1ic3nKWgjq8qfVYGQG1gRt6rs62a6HiqqUOqdesK5NmX4nGofJoiE1d0dF9lVVkvT1/kEEaaCoYOwFpcVcoLM+7669PxC9rWqktH0sWUYld0VCpuBZ/stVRcGgy9WX2+U1Qthi9SzAqSxzZsy+OiFzBYnySGV6Gku44rD8BCOZBV3BvD5+AKRHNwMEsB6EzHnJpkTAeiUlEGkcECeB6GDZTp5YEJTlvdrknxYjTllMkfNtXwDjM7uVjK5JXUUn43rrqpK2jytaxHW0M5G8DC8rtHMYs7KSgduVQMGTYFqFvVS6rkD3sDJ46afdYFwoq11AOKCBLhvwoUgc8IGANycR6knZrdJPdsuxnyjfd3FovTlRMdEdtOl5CMV5EHsXQBis7TOwvIDZaGj2Vnpbh7cpK63VwYEMLwqbjzyl699sawFFkF1yqjUU31HfC6sW1ZFVFuXVXVgz9keEaw0ys1lWfm+azQAQSWA+hKYVfsZjPncAcUB9oIayy/UZXRNckDGji77GsWbvBo6tPrWPqOyVkBUq+INeqpzNdYs/u0ifh5qmpqIW+33JVSUcwY70KL4U9lYdU6ljtSls7lmfi9g3YzeQfVkaGFaV3ODCnaD2N8wsEDFklE3RzM3ZghdYkWHsszq70FIecnKkVkt8ezMzRq9bkGuKojRLBVSod3Y1yPqKgYW7JRQTPVyy5xIYLjOgxgT52RKJUY1dOrIiRd4futQx/A5AcSmEjz0vFWrkLzvbWAu9HOWbGgxFk1VNTpnBKk6TgwisI/HcxYXP1uAWO72ULFlBTq+aSu2VTUs6hrxM2CF+hEor1VIA9ZmFUaab1lSSgZsVs4sxzHlVLoJHr9H4DhONTkI1XC0/wiY2NoWAG5RlnHFnq6oLccpQddMuJ/O17JVA5OHLi0BqCztq7Y1++ucCd98qLI8MIHBV/cKjxQTme3hFBS3MyCqnDsuym2o80HjvFFTtrURmNaGJsmVahImjTsUXKtQZTAVs7Mvv8/+fzUrZAXcLJ6M4koe6XP0b6SmWWNDzyUpQ8bl+LtWx4tuqZ36cRYV3yuVxPNwvIiqiQCSmu7srgTzR6nkyhpCarXwFy1vGd5iP2cY06lFr5Njhhg1Y6+NB28ftbK83s8rf7kLJbKwDFPbLg25a0AdZJEiqr5phixKMDlRUtcssq1hriLqGoH+zeNgVm9OemjsETV8JdF0NHnkIFxWY1OB4Yrp7rtWJ7NgAAAPXklEQVQ3oNs5nplyVf8u2FoLu1JrHveaZWQjqAkshtFa2gzsSG3Zpkbvg3HafF9slPPlldjFlK80Gysm8Mr4MPhneNWENPGjAIpmilTPATdTRTXlCBYHYAQuPwA36xIpWtGN4q3Y2MhiGsUpuSSnlEJRD8PorC7CFYVw+F51qThgabxsTxWzCGY0ZSsb3lfqAy0OPNjNy8xiQQKsHYFQ2HBZVvVbBuq3m1oWKajqaonsM6uZUr6CjXWNZ0l5E3h3jURma6kP3MJIiy1Lm+kahQq41N2iZja5sjtlLYNZHZrH6qUGm4vMbDp6Rw2CFmvuyFkrBcCyMtFqBaECmsHoK9BZ2LA/lJcRqSaDqnaWbrZdGaz3DLgIvBln4woGztbyJGqslwxkhhHrTjTYFXCtOoKS8uLdofVdAbOylGU6nlYpXWZts4nXBq6WxJitMNokHUJnbnJplQm+aGpY2a5GMV2QD1hRubBPFKdumf5OHkLHz0F9luE5kjBjRa0nFE5CUGqHw32MmjZ6xkgINVnSnZ1VZStK2qKlRaLlQgK7uTq7JFXJwM+3SOEKyhZNI+tJ0I5qMYy9k2qJD7dVWdqKXa0CKNR0Ccjg+B2IYu2fcBZJZkMFgM11r0X92wilghFGgzVnexlqB7xL9mS29SiYUVY2nXOZjNBRsyDsQPRWW5hrZ4XcdC4HVWRbjgJr4sFofK5SzjQ7rhI1UebdPdEbj6sqIvTZQZ5va08rABsAW0UxeWytAk7A2KJ9ZpxzCioB24XFtYAeXYxr6anSqhLgppEqWbGwLunTgrV+IjWlL29ljaAl4EQMGsErp4apeZiquwRXLXAqOCeru32mmydc6oWTSWpFAGdzeTB8RTHVMEtlM90CbbQCYhPjq3egYr1FGdYIQjiuDGZ5zZ/AzobKGOyLxti6c4Rwtv2anyWlLICnlLhxJRXt6A5ebDBWFNONbxWZ2d02mnu4S9YECpeppV1zSWRBWxHYzVIv1CXSouwqqX3jBBBDZdYQbpTQW4ZQlS8r5kH4suSRmg2++3JN10x1PaAmEkmtYlEdeGpJEM6kOuCqCR22oSujj5IV2HdT0zj5prLKTjXFAPjdQlyq7xIBxAQP5yMczG4VxAKw0n6ilZ2QBce2pLulkuxxqnoIzFfgqyqjil9S1VNwBrFmeyeops8yOjZUybZdfS8CuaTIJumzs5tODaNtLpFDQ/PcJGweLhmeL1nB0KqiUDScsiUVD89Di3HtrKtSULw3RLiygZD+7sF8JTObgYsrGvDNUFRGl1iy0Ll1YkUc2aJYMog920I8qW6YDCg1Mqk0JHJFKXkbgbRreI+qpYNOZHrVcDUba7pjsphSJNtK6upgRNAVoOS0mugBeN4bIZgHhuPZ/s1ENaX6KsVr+YNrh1Nb7ipR0PE5zbNRegCbrHRUw6Yf07dLBJl1f8KB9as2V1nNqAsl62LBBhehwalerkHmB1JFIEZKSEusdl5JQj1nJlHXSCF342gJ9CYGrXelknJIXqVP8sD+qtplCR3XH2qfKq0ygMp+KnVkKxNlZ8m2YkIlVMiCnXUwl7qznBKSvQz3m3Pt6oQbXO5b5FixCh/fHxUQW/AEcK6zCNqKQnL9sywqmKuwvqSYzT/aPVNNpVyhvRW21aqciCsjdWvBwILUvh5VyCzbWoC1pJjJ680CWsl+udKB6T5RwG1mlohnlpbg47iz5U9ha0FGtmRLFYBtO99y97Ap0z+ZDTAog6kSLZsMHg/IFkkgp6CpvU2U0cYVSdnmkjwBdOmXbxTWNWzuIbipMioVxEckZEoahSOiy2M3K0jcC1LhVDwaqG0ZvkcWqCnrG4GIxykrqlbWdw6LQyBaZR8HmLRIhQWsHswD42ZXVLNkf9l+FlW0HVQ2lwFsC/Z1FdzlQR0KaPfo+Fdfu+/dwVRICu1CGR7AEIiAhc+AZUF0kOBaPxmUqg4i64vQnU4nFDYJ9Nz+1fVXveH9qmr+kPILx8oKcRV/BFbxbE0JMT0kSD4w6L/lNY8ocsqagVdU3A3MjxhxcGuqzsPH4irpaow1q6OyrVjvp9Npc59E91LldboYVzJWdimWfAW2SNEKcDaX2FmBLLA/uKxlmhh613Is1URQApbKfttwxL02q6Onx5pQxSbPojAg+v5hAnN6LHVRDXIsvKtRjiS0qJUyZTAXVbAK82ElFJWaQdVoqUC1Unt7BVaTQudM6SuqexjQJN4+0icaxv/utbKv83ETbT8H8gjcOKxOJmbUa6OOVXht3dFY6rHv9XoNzFLceEA1o8+pKm0LAHPHZ2rYKjFq0hfZFixsqHJgD3eD5n+U0kb1mFjXkn2lvMSSOsNE/CdIAKF0Sytq6urOHUN5gwg4GZosgbmggM5ucra2qrS2Ig1cbiBBcxYzgzUDNLCvL8GbZXNp6ORy3LmS+Kk83zRIAK6A1ioKa2I9NapIuiUFdfC9766PFZUtqUr6KbWk+zZU1a/ZrIXEztrjTOfz7hwKziCeXIaraHtbZIMz+2pGgazCmw4qWAFvEdhodYp0Xq0pV7G1YWYWbO4qhGq42+Z8BYtrLWvluNPpZAeaFFS1vubPgbgxsqcpnAaszBovKaFoDQ8BGtjfUOl4NAG2nmQV04feJgumvX2fsrQEWZghL0JnVdYkn3DOZIeRN86RqPWCmsvGVqEMRnwxQAxwS8EMYo3IzmY2+BCcLp4MKiuyuhImamlbZFcNoNl7tp+RHd18ZjQIRKyXdFRhN98/hyKqwXWNo7O1wiaXoHN108REZZWEq6grnIfjzeg8jdRf1XEL4kkXa5bBjKxoKaljBjeHlVxQ4GaycpW4lDOAKtnTxHAtOfzOtZwHAM7sqVXkV6yu6kap1nHkXKqWF/4XHqjenNKqBjpR3l1ch3Ejg1+EsgdQhsdG0B4FM9sWAVWpuAyiwTPleZxt9VyZVS2qXfReWqTAilpr9ApoWTjxymit7NwV4JTriZyOA9B0k7HFfULourmKYHVnRQvqGL5HMHdqFcR2qWpmcK6eTwx2dipWrviDilr+fKWq3OWRWdHKwA4eu8wjchbeRzFilqjjZN3ufCpfkJ0/scVpnYk6L0PI77lxdWCZ87WiWm7B/AGquQSnujGKsB8CJmiJq8q1pKIVWyqOiTK66r18BN8r74/AE71fdC3yPS2MxdOpnE1tlVxD9JmVOoggN+r4PjAXVFPa3Eg5jVJGFVUGNolH20GVrUB7BOySWq6WqYQdWR92pcFMYMwckbSgCKCqD67DiiWu1g8MQC9ByfcFqW1L+jL714qNCuznoSxt0da2gtWN1G8F0BK0NN0nuimelUF9dIdAfjO44UT3CjQLoUeLHJFTO3gmpRuIIOvwBQCbqNeo3qtZ9iF6xVK13GRlo4zqimq+CGdTiR1uRY8oqgE02hZBa79kZXPMquxRHKla2saZWN4mRqZUj0vLCKhkjKnqOQHNuSZVJoKvAqS1wpEquvWDC1B2ypwrCPsRMEPVTODMLJMDv6qeKXwi2JYV5Sq4qKyvgGsHCLiuj2jR59V8gMqSJ2FJZRXEHVRHj3sFPrct6OpqlW1GpatQdt0GvwfM6n63InsGVFhJGaBqgqqIV6IsXllZgySPq4R3bnt3wi5cv+cN2yqQLW1T95KYVsWWtKk4cB9W53WQQflQYR6Wl4HaJZjvVE0D5yvq+RKgZCs5qdBEP5sD94cAvQLlSgNaSMAtHx88BuNQ41zdFsX30zKbcs0MLD/ihkpQzl0wiTqKLTfbKmCmyYICnK0IbaieC4CG9iSyLQ7cIMGQwau6TKoq60Apl3WN40LZpca1CKKK9VQyyIEn8w0F8F6CL2h8o3ixGwC7s7EWzCOqmcApYxYD4jsAzVS0sl2t98pA7vrKophCVSonbYpgH6mvSn24pTBV4sdtV3BtMq5k82y+IADvUJ0uAlkCVTxIaPm+UNu/qkV4F1TzHXCGrXIAqItBKypqK99VtAOVs64O4ObX7pHLVCpYHcRmwvLR7TvYAKBBN58LGVzDuFz+hQbWgncQyCZAk+VbsPSouf93261iZgmfCpwRbAvqmSqriU2PwhjaoOyYqtIegVXViTsmyta6bGySpY3gyRrpIyAeaWDDxtpsXwKyalMDKNP7YBXMqEskUsi2uC8FNAPxAKTVfT1o6VzM0E0jF+1rWcUuHvdyg7vgoFplX8HpvHpMCOMRUPHzZkInsqlFKNX/EIO52E0SxSzOwob2VmRLW5D1XIU0rbgM1AzWgyC7fe8G7xUAK/taEBat7luqtyP7EmsaJQOj5F+mrnZfCuYCfBUAWwShyd6pMY/vAHG1UqOYpbI/gy5T0CMKm+UO3gFuC85dgfDVeguPDfITrIBLsLrcgdh3CFgFZjaKJ4Iv3F8ANEqvuxR1tVKOgLoCa1jxboBAkj6v7j/icFbA7f4rfRnQDLRViG13i0vqBQrYVqBbADZT0ZpiHoSzvQpopKIFS3sE1HfBWlHXd0H7LnArqvougMtljHBgZnh3Eoz/BKjLML4Z2Aq0+hEJr9jaVUBbvNzCIUiroC7AWmmFw4o5AK3MtB5VypZMSFgs05JyGVwlwBqsEGAAa2ZU1CjUexXGsE4rKriilBvFzOKKo3AuAroE6QFQU3u8YpNXwS5k+1TZt5UrwouN4KiUEw+k3ZWDp1RXHNRqXb21Ts39945yZSg3VnZFNQ9CF3XeZyr5DgBXKiwCMa2MxeTDYXgP1Fsf9QNKZc0k81RJk3r6EQ3rCmBVyLL75EjZ1pIVDHoFtiOAHoB0BdTVylqBsKKKS+AeBXJVLY+CXASuGvO/Auq7GuEjDfGKg1oKa1z/dmmi9I9SUGNhl0AtfulHAawoYrnSkmNXAVuGEhrEVXvUF+A5Ct2PqNOjDetyna4CmeUolmeXLN4Aq7C5Sj10Q7yjgl+t6CNxSRHmI5X+CpwreYB3Qfdqna4q21KdBuc4GoZsn49ZOOiVinwHqK9WzjvgeweEh2AU5+vtxZ9Cd9Wqkh49V18E5oj6vVyn0RStAyGIO5edXRKd5B0VGVXq2yr3xYp+5Ut+C4QJ4P1N339pQMjRejj4vb/Dcr6rQc3O/0rjmtZpeYCBiCHfCemRbNhbK/pNUPc3wfKy5f2D7OlL3/uPhve/oU4T0F8f+VNM2vyoiv0jK+KHQfdHq+0bncz4oz73/+Y6LbKw1o/5B7eOf1Rl/0du9B9tn/9bvrf/j+v0h6ttn2tp/r/4819y4/zv5391uvzzfwDifz6phT1MPgAAAABJRU5ErkJggg==");background-size:100% 100%;border:none;cursor:pointer;direction:ltr;height:130px;touch-action:manipulation;width:100%}.color-picker .cp-add-color-button-class{background:transparent;border:0;cursor:pointer;display:inline;margin:3px -3px;padding:0;position:absolute}.color-picker .cp-add-color-button-class:hover{text-decoration:underline}.color-picker .cp-add-color-button-class:disabled{color:#999;cursor:not-allowed}.color-picker .cp-add-color-button-class:disabled:hover{text-decoration:none}.color-picker .cp-remove-color-button-class{background:#fff;border-radius:50%;box-shadow:1px 1px 5px #333;cursor:pointer;display:block;height:10px;position:absolute;right:-5px;text-align:center;top:-5px;width:10px}.color-picker .cp-remove-color-button-class:before{bottom:3.5px;content:"x";display:inline-block;font-size:10px;position:relative}',
                            ],
                            encapsulation: 2,
                        })),
                        t
                    );
                })(),
                nf = (() => {
                    class t {
                        constructor(t, e, n, r, s, i) {
                            (this.injector = t),
                                (this.cfr = e),
                                (this.appRef = n),
                                (this.vcRef = r),
                                (this.elRef = s),
                                (this._service = i),
                                (this.dialogCreated = !1),
                                (this.ignoreChanges = !1),
                                (this.viewAttachedToAppRef = !1),
                                (this.cpWidth = "230px"),
                                (this.cpHeight = "auto"),
                                (this.cpToggle = !1),
                                (this.cpDisabled = !1),
                                (this.cpIgnoredElements = []),
                                (this.cpFallbackColor = ""),
                                (this.cpColorMode = "color"),
                                (this.cpCmykEnabled = !1),
                                (this.cpOutputFormat = "auto"),
                                (this.cpAlphaChannel = "enabled"),
                                (this.cpDisableInput = !1),
                                (this.cpDialogDisplay = "popup"),
                                (this.cpSaveClickOutside = !0),
                                (this.cpCloseClickOutside = !0),
                                (this.cpUseRootViewContainer = !1),
                                (this.cpPosition = "auto"),
                                (this.cpPositionOffset = "0%"),
                                (this.cpPositionRelativeToArrow = !1),
                                (this.cpOKButton = !1),
                                (this.cpOKButtonText = "OK"),
                                (this.cpOKButtonClass = "cp-ok-button-class"),
                                (this.cpCancelButton = !1),
                                (this.cpCancelButtonText = "Cancel"),
                                (this.cpCancelButtonClass =
                                    "cp-cancel-button-class"),
                                (this.cpPresetLabel = "Preset colors"),
                                (this.cpPresetColorsClass =
                                    "cp-preset-colors-class"),
                                (this.cpMaxPresetColorsLength = 6),
                                (this.cpPresetEmptyMessage = "No colors added"),
                                (this.cpPresetEmptyMessageClass =
                                    "preset-empty-message"),
                                (this.cpAddColorButton = !1),
                                (this.cpAddColorButtonText = "Add color"),
                                (this.cpAddColorButtonClass =
                                    "cp-add-color-button-class"),
                                (this.cpRemoveColorButtonClass =
                                    "cp-remove-color-button-class"),
                                (this.cpInputChange = new Rl(!0)),
                                (this.cpToggleChange = new Rl(!0)),
                                (this.cpSliderChange = new Rl(!0)),
                                (this.cpSliderDragEnd = new Rl(!0)),
                                (this.cpSliderDragStart = new Rl(!0)),
                                (this.colorPickerOpen = new Rl(!0)),
                                (this.colorPickerClose = new Rl(!0)),
                                (this.colorPickerCancel = new Rl(!0)),
                                (this.colorPickerSelect = new Rl(!0)),
                                (this.colorPickerChange = new Rl(!1)),
                                (this.cpCmykColorChange = new Rl(!0)),
                                (this.cpPresetColorsChange = new Rl(!0));
                        }
                        handleClick() {
                            this.inputFocus();
                        }
                        handleFocus() {
                            this.inputFocus();
                        }
                        handleInput(t) {
                            this.inputChange(t);
                        }
                        ngOnDestroy() {
                            null != this.cmpRef &&
                                (this.viewAttachedToAppRef &&
                                    this.appRef.detachView(
                                        this.cmpRef.hostView
                                    ),
                                this.cmpRef.destroy(),
                                (this.cmpRef = null),
                                (this.dialog = null));
                        }
                        ngOnChanges(t) {
                            t.cpToggle &&
                                !this.cpDisabled &&
                                (t.cpToggle.currentValue
                                    ? this.openDialog()
                                    : t.cpToggle.currentValue ||
                                      this.closeDialog()),
                                t.colorPicker &&
                                    (this.dialog &&
                                        !this.ignoreChanges &&
                                        ("inline" === this.cpDialogDisplay &&
                                            this.dialog.setInitialColor(
                                                t.colorPicker.currentValue
                                            ),
                                        this.dialog.setColorFromString(
                                            t.colorPicker.currentValue,
                                            !1
                                        ),
                                        this.cpUseRootViewContainer &&
                                            "inline" !== this.cpDialogDisplay &&
                                            this.cmpRef.changeDetectorRef.detectChanges()),
                                    (this.ignoreChanges = !1)),
                                (t.cpPresetLabel || t.cpPresetColors) &&
                                    this.dialog &&
                                    this.dialog.setPresetConfig(
                                        this.cpPresetLabel,
                                        this.cpPresetColors
                                    );
                        }
                        openDialog() {
                            if (this.dialogCreated)
                                this.dialog &&
                                    this.dialog.openDialog(this.colorPicker);
                            else {
                                let t = this.vcRef;
                                if (
                                    ((this.dialogCreated = !0),
                                    (this.viewAttachedToAppRef = !1),
                                    this.cpUseRootViewContainer &&
                                        "inline" !== this.cpDialogDisplay)
                                ) {
                                    const e = this.injector.get(
                                        this.appRef.componentTypes[0],
                                        Ji.NULL
                                    );
                                    e !== Ji.NULL
                                        ? ((t =
                                              e.vcRef ||
                                              e.viewContainerRef ||
                                              this.vcRef),
                                          t === this.vcRef &&
                                              console.warn(
                                                  "You are using cpUseRootViewContainer, but the root component is not exposing viewContainerRef!Please expose it by adding 'public vcRef: ViewContainerRef' to the constructor."
                                              ))
                                        : (this.viewAttachedToAppRef = !0);
                                }
                                const e = this.cfr.resolveComponentFactory(ef);
                                if (this.viewAttachedToAppRef)
                                    (this.cmpRef = e.create(this.injector)),
                                        this.appRef.attachView(
                                            this.cmpRef.hostView
                                        ),
                                        document.body.appendChild(
                                            this.cmpRef.hostView.rootNodes[0]
                                        );
                                else {
                                    const n = Mo.fromResolvedProviders(
                                        [],
                                        t.parentInjector
                                    );
                                    this.cmpRef = t.createComponent(
                                        e,
                                        0,
                                        n,
                                        []
                                    );
                                }
                                this.cmpRef.instance.setupDialog(
                                    this,
                                    this.elRef,
                                    this.colorPicker,
                                    this.cpWidth,
                                    this.cpHeight,
                                    this.cpDialogDisplay,
                                    this.cpFallbackColor,
                                    this.cpColorMode,
                                    this.cpCmykEnabled,
                                    this.cpAlphaChannel,
                                    this.cpOutputFormat,
                                    this.cpDisableInput,
                                    this.cpIgnoredElements,
                                    this.cpSaveClickOutside,
                                    this.cpCloseClickOutside,
                                    this.cpUseRootViewContainer,
                                    this.cpPosition,
                                    this.cpPositionOffset,
                                    this.cpPositionRelativeToArrow,
                                    this.cpPresetLabel,
                                    this.cpPresetColors,
                                    this.cpPresetColorsClass,
                                    this.cpMaxPresetColorsLength,
                                    this.cpPresetEmptyMessage,
                                    this.cpPresetEmptyMessageClass,
                                    this.cpOKButton,
                                    this.cpOKButtonClass,
                                    this.cpOKButtonText,
                                    this.cpCancelButton,
                                    this.cpCancelButtonClass,
                                    this.cpCancelButtonText,
                                    this.cpAddColorButton,
                                    this.cpAddColorButtonClass,
                                    this.cpAddColorButtonText,
                                    this.cpRemoveColorButtonClass,
                                    this.elRef
                                ),
                                    (this.dialog = this.cmpRef.instance),
                                    this.vcRef !== t &&
                                        this.cmpRef.changeDetectorRef.detectChanges();
                            }
                        }
                        closeDialog() {
                            this.dialog &&
                                "popup" === this.cpDialogDisplay &&
                                this.dialog.closeDialog();
                        }
                        cmykChanged(t) {
                            this.cpCmykColorChange.emit(t);
                        }
                        stateChanged(t) {
                            this.cpToggleChange.emit(t),
                                t
                                    ? this.colorPickerOpen.emit(
                                          this.colorPicker
                                      )
                                    : this.colorPickerClose.emit(
                                          this.colorPicker
                                      );
                        }
                        colorChanged(t, e = !0) {
                            (this.ignoreChanges = e),
                                this.colorPickerChange.emit(t);
                        }
                        colorSelected(t) {
                            this.colorPickerSelect.emit(t);
                        }
                        colorCanceled() {
                            this.colorPickerCancel.emit();
                        }
                        inputFocus() {
                            const t = this.elRef.nativeElement,
                                e = this.cpIgnoredElements.filter(
                                    (e) => e === t
                                );
                            this.cpDisabled ||
                                e.length ||
                                ("undefined" != typeof document &&
                                t === document.activeElement
                                    ? this.openDialog()
                                    : this.dialog && this.dialog.show
                                    ? this.closeDialog()
                                    : this.openDialog());
                        }
                        inputChange(t) {
                            this.dialog
                                ? this.dialog.setColorFromString(
                                      t.target.value,
                                      !0
                                  )
                                : ((this.colorPicker = t.target.value),
                                  this.colorPickerChange.emit(
                                      this.colorPicker
                                  ));
                        }
                        inputChanged(t) {
                            this.cpInputChange.emit(t);
                        }
                        sliderChanged(t) {
                            this.cpSliderChange.emit(t);
                        }
                        sliderDragEnd(t) {
                            this.cpSliderDragEnd.emit(t);
                        }
                        sliderDragStart(t) {
                            this.cpSliderDragStart.emit(t);
                        }
                        presetColorsChanged(t) {
                            this.cpPresetColorsChange.emit(t);
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(
                                Ro(Ji),
                                Ro(Ia),
                                Ro(Vc),
                                Ro(fl),
                                Ro(Ma),
                                Ro(tf)
                            );
                        }),
                        (t.ɵdir = Ht({
                            type: t,
                            selectors: [["", "colorPicker", ""]],
                            hostBindings: function (t, e) {
                                1 & t &&
                                    qo("click", function () {
                                        return e.handleClick();
                                    })("focus", function () {
                                        return e.handleFocus();
                                    })("input", function (t) {
                                        return e.handleInput(t);
                                    });
                            },
                            inputs: {
                                cpWidth: "cpWidth",
                                cpHeight: "cpHeight",
                                cpToggle: "cpToggle",
                                cpDisabled: "cpDisabled",
                                cpIgnoredElements: "cpIgnoredElements",
                                cpFallbackColor: "cpFallbackColor",
                                cpColorMode: "cpColorMode",
                                cpCmykEnabled: "cpCmykEnabled",
                                cpOutputFormat: "cpOutputFormat",
                                cpAlphaChannel: "cpAlphaChannel",
                                cpDisableInput: "cpDisableInput",
                                cpDialogDisplay: "cpDialogDisplay",
                                cpSaveClickOutside: "cpSaveClickOutside",
                                cpCloseClickOutside: "cpCloseClickOutside",
                                cpUseRootViewContainer:
                                    "cpUseRootViewContainer",
                                cpPosition: "cpPosition",
                                cpPositionOffset: "cpPositionOffset",
                                cpPositionRelativeToArrow:
                                    "cpPositionRelativeToArrow",
                                cpOKButton: "cpOKButton",
                                cpOKButtonText: "cpOKButtonText",
                                cpOKButtonClass: "cpOKButtonClass",
                                cpCancelButton: "cpCancelButton",
                                cpCancelButtonText: "cpCancelButtonText",
                                cpCancelButtonClass: "cpCancelButtonClass",
                                cpPresetLabel: "cpPresetLabel",
                                cpPresetColorsClass: "cpPresetColorsClass",
                                cpMaxPresetColorsLength:
                                    "cpMaxPresetColorsLength",
                                cpPresetEmptyMessage: "cpPresetEmptyMessage",
                                cpPresetEmptyMessageClass:
                                    "cpPresetEmptyMessageClass",
                                cpAddColorButton: "cpAddColorButton",
                                cpAddColorButtonText: "cpAddColorButtonText",
                                cpAddColorButtonClass: "cpAddColorButtonClass",
                                cpRemoveColorButtonClass:
                                    "cpRemoveColorButtonClass",
                                colorPicker: "colorPicker",
                                cpPresetColors: "cpPresetColors",
                            },
                            outputs: {
                                cpInputChange: "cpInputChange",
                                cpToggleChange: "cpToggleChange",
                                cpSliderChange: "cpSliderChange",
                                cpSliderDragEnd: "cpSliderDragEnd",
                                cpSliderDragStart: "cpSliderDragStart",
                                colorPickerOpen: "colorPickerOpen",
                                colorPickerClose: "colorPickerClose",
                                colorPickerCancel: "colorPickerCancel",
                                colorPickerSelect: "colorPickerSelect",
                                colorPickerChange: "colorPickerChange",
                                cpCmykColorChange: "cpCmykColorChange",
                                cpPresetColorsChange: "cpPresetColorsChange",
                            },
                            exportAs: ["ngxColorPicker"],
                            features: [ne],
                        })),
                        t
                    );
                })(),
                rf = (() => {
                    class t {}
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)();
                            },
                            providers: [tf],
                            imports: [[eu]],
                        })),
                        t
                    );
                })(),
                sf = (() => {
                    class t {
                        constructor() {}
                        transform(t) {
                            return t;
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)();
                        }),
                        (t.ɵpipe = {
                            type: (e = { name: "cast", type: t, pure: !0 })
                                .type,
                            name: e.name,
                            factory: null,
                            pure: !1 !== e.pure,
                            onDestroy: e.type.prototype.ngOnDestroy || null,
                        }),
                        t
                    );
                    var e;
                })();
            const of = ["colorPicker"];
            function af(t, e) {
                1 & t && jo(0, "fa-icon", 12),
                    2 & t && No("icon", Uo(3).faCheck);
            }
            function lf(t, e) {
                1 & t && jo(0, "span", 18);
            }
            function cf(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div"),
                        Vo(1, "button", 15),
                        qo("click", function () {
                            Ee(t);
                            const n = e.$implicit,
                                r = e.index;
                            return Uo(2).setToSwatch(n, r);
                        }),
                        fa(2),
                        lo(3, af, 1, 1, "fa-icon", 16),
                        lo(4, lf, 1, 0, "span", 17),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = e.$implicit,
                        n = e.index,
                        r = Uo(2);
                    oo("id", t.id),
                        Hs(1),
                        oo("id", t.id),
                        Hs(1),
                        ga(t.name),
                        Hs(1),
                        No(
                            "ngIf",
                            "swatch" === r.status.method &&
                                r.status.index === n &&
                                r.status.active
                        ),
                        Hs(1),
                        No(
                            "ngIf",
                            "swatch" === r.status.method &&
                                r.status.index === n &&
                                r.status.loading
                        );
                }
            }
            function uf(t, e) {
                1 & t && jo(0, "fa-icon", 12),
                    2 & t && No("icon", Uo(3).faCheck);
            }
            function hf(t, e) {
                1 & t && jo(0, "span", 18);
            }
            function df(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "button", 19, 20),
                        qo("colorPickerChange", function (n) {
                            Ee(t);
                            const r = e.$implicit,
                                s = e.index;
                            return Uo(2).onChange(n, r, s);
                        }),
                        Ml(2, "cast"),
                        Vo(3, "span"),
                        fa(4),
                        Vo(5, "span", 21),
                        fa(6),
                        Ml(7, "cast"),
                        Fo(),
                        Fo(),
                        lo(8, uf, 1, 1, "fa-icon", 16),
                        lo(9, hf, 1, 0, "span", 17),
                        Fo();
                }
                if (2 & t) {
                    const t = e.$implicit,
                        n = e.index,
                        r = Uo(2);
                    No("ngClass", t.class)(
                        "colorPicker",
                        r.colors[Pl(2, 7, t.id)]
                    ),
                        oo("data-palette-id", t.id),
                        Hs(4),
                        ma(" ", t.name, " \xa0"),
                        Hs(2),
                        ga(r.colors[Pl(7, 9, t.id)]),
                        Hs(2),
                        No(
                            "ngIf",
                            (("palette" === r.status.method &&
                                r.status.index === n) ||
                                ("random" === r.status.method &&
                                    (0 === n || 1 === n || 5 === n))) &&
                                r.status.active
                        ),
                        Hs(1),
                        No(
                            "ngIf",
                            (("palette" === r.status.method &&
                                r.status.index === n) ||
                                ("random" === r.status.method &&
                                    (0 === n || 1 === n || 5 === n))) &&
                                r.status.loading
                        );
                }
            }
            function pf(t, e) {
                if (1 & t) {
                    const t = Ho();
                    zo(0),
                        Vo(1, "div", 4),
                        fa(2, "Theme Customizer"),
                        Fo(),
                        Vo(3, "div", 5),
                        Vo(4, "div"),
                        Vo(5, "h6", 6),
                        fa(6, "Try a pre-built swatch!"),
                        Fo(),
                        Vo(7, "div", 7),
                        lo(8, cf, 5, 5, "div", 8),
                        Fo(),
                        Vo(9, "h6", 6),
                        fa(10, "Or choose your own colors..."),
                        Fo(),
                        Vo(11, "div", 9),
                        lo(12, df, 10, 11, "button", 10),
                        Fo(),
                        Vo(13, "h6", 6),
                        fa(14, "Need ideas? Randomize!"),
                        Fo(),
                        Vo(15, "button", 11),
                        qo("click", function () {
                            return Ee(t), Uo().randomPalette();
                        }),
                        fa(16, "Randomize Colors"),
                        jo(17, "fa-icon", 12),
                        Fo(),
                        jo(18, "hr"),
                        Vo(19, "h6", 6),
                        fa(
                            20,
                            "Finished? Export your color palette file with install instructions!"
                        ),
                        Fo(),
                        Vo(21, "button", 13),
                        qo("click", function () {
                            return Ee(t), Uo().exportOverrides();
                        }),
                        fa(22, "Export"),
                        jo(23, "fa-icon", 12),
                        Fo(),
                        Fo(),
                        Vo(24, "div"),
                        jo(25, "hr"),
                        Vo(26, "div", 14),
                        fa(
                            27,
                            "Note: This customizer web component is an online-only tool and is not part of the download package when purchasing the theme."
                        ),
                        Fo(),
                        Fo(),
                        Fo(),
                        Bo();
                }
                if (2 & t) {
                    const t = Uo();
                    Hs(8),
                        No("ngForOf", t.sbProSwatches),
                        Hs(4),
                        No("ngForOf", t.palettes),
                        Hs(5),
                        No("icon", t.faRandom),
                        Hs(6),
                        No("icon", t.faFileDownload);
                }
            }
            const ff = function (t) {
                return { selected: t };
            };
            function gf(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "div", 29),
                        qo("keyup.enter", function () {
                            Ee(t);
                            const n = e.$implicit,
                                r = e.index;
                            return Uo(2).setToSwatch(n, r);
                        })("click", function () {
                            Ee(t);
                            const n = e.$implicit,
                                r = e.index;
                            return Uo(2).setToSwatch(n, r);
                        }),
                        Vo(1, "div", 30),
                        jo(2, "div", 31),
                        jo(3, "div", 32),
                        Fo(),
                        Fo();
                }
                if (2 & t) {
                    const t = e.$implicit,
                        s = e.index,
                        i = Uo(2);
                    No(
                        "ngClass",
                        (5,
                        (n = ff),
                        (r =
                            s === i.selectedSwatchIndex &&
                            !i.customColorsSelected),
                        Ol(ke(), Ne(), 5, n, r, undefined))
                    ),
                        Hs(2),
                        ta("background-color", t.colors.primary),
                        Hs(1),
                        ta("background-color", t.colors.secondary);
                }
                var n, r;
            }
            function mf(t, e) {
                1 & t && jo(0, "fa-icon", 12),
                    2 & t && No("icon", Uo(3).faCheck);
            }
            function yf(t, e) {
                1 & t && jo(0, "span", 18);
            }
            function vf(t, e) {
                if (1 & t) {
                    const t = Ho();
                    Vo(0, "button", 19, 20),
                        qo("colorPickerChange", function (n) {
                            Ee(t);
                            const r = e.$implicit,
                                s = e.index;
                            return Uo(2).onChange(n, r, s);
                        }),
                        Ml(2, "cast"),
                        Vo(3, "span"),
                        fa(4),
                        Vo(5, "span", 21),
                        fa(6),
                        Ml(7, "cast"),
                        Fo(),
                        Fo(),
                        lo(8, mf, 1, 1, "fa-icon", 16),
                        lo(9, yf, 1, 0, "span", 17),
                        Fo();
                }
                if (2 & t) {
                    const t = e.$implicit,
                        n = e.index,
                        r = Uo(2);
                    No("ngClass", t.class)(
                        "colorPicker",
                        r.colors[Pl(2, 7, t.id)]
                    ),
                        oo("data-palette-id", t.id),
                        Hs(4),
                        ma(" ", t.name, " \xa0"),
                        Hs(2),
                        ga(r.colors[Pl(7, 9, t.id)]),
                        Hs(2),
                        No(
                            "ngIf",
                            (("palette" === r.status.method &&
                                r.status.index === n) ||
                                ("random" === r.status.method &&
                                    (0 === n || 1 === n || 5 === n))) &&
                                r.status.active
                        ),
                        Hs(1),
                        No(
                            "ngIf",
                            (("palette" === r.status.method &&
                                r.status.index === n) ||
                                ("random" === r.status.method &&
                                    (0 === n || 1 === n || 5 === n))) &&
                                r.status.loading
                        );
                }
            }
            function bf(t, e) {
                if (1 & t) {
                    const t = Ho();
                    zo(0),
                        Vo(1, "div", 4),
                        fa(2, "Theme Customizer"),
                        Vo(3, "sup"),
                        fa(4, "*"),
                        Fo(),
                        Fo(),
                        Vo(5, "div", 5),
                        Vo(6, "div"),
                        Vo(7, "h6"),
                        fa(8, "Change the theme type!"),
                        Fo(),
                        Vo(9, "div", 22),
                        Vo(10, "div", 23),
                        Vo(11, "button", 24),
                        qo("click", function () {
                            return Ee(t), Uo().changeThemeType("light");
                        }),
                        fa(12, "Light"),
                        Fo(),
                        Fo(),
                        Vo(13, "div", 23),
                        Vo(14, "button", 25),
                        qo("click", function () {
                            return Ee(t), Uo().changeThemeType("dark");
                        }),
                        fa(15, "Dark"),
                        Fo(),
                        Fo(),
                        Vo(16, "div", 23),
                        Vo(17, "button", 26),
                        qo("click", function () {
                            return Ee(t), Uo().changeThemeType("primary");
                        }),
                        fa(18, "Primary"),
                        Fo(),
                        Fo(),
                        Fo(),
                        Vo(19, "h6"),
                        fa(20, "Try a pre-built swatch!"),
                        Fo(),
                        Vo(21, "div", 27),
                        lo(22, gf, 4, 7, "div", 28),
                        Fo(),
                        Vo(23, "h6", 6),
                        fa(24, "Or choose your own colors..."),
                        Fo(),
                        Vo(25, "div", 9),
                        lo(26, vf, 10, 11, "button", 10),
                        Fo(),
                        Vo(27, "h6", 6),
                        fa(28, "Need ideas? Randomize!"),
                        Fo(),
                        Vo(29, "button", 11),
                        qo("click", function () {
                            return Ee(t), Uo().randomPalette();
                        }),
                        fa(30, "Randomize Colors"),
                        jo(31, "fa-icon", 12),
                        Fo(),
                        jo(32, "hr"),
                        Vo(33, "h6", 6),
                        fa(
                            34,
                            "Finished? Export your color palette file with install instructions!"
                        ),
                        Fo(),
                        Vo(35, "button", 13),
                        qo("click", function () {
                            return Ee(t), Uo().exportOverrides();
                        }),
                        fa(36, "Export"),
                        jo(37, "fa-icon", 12),
                        Fo(),
                        Fo(),
                        Vo(38, "div"),
                        jo(39, "hr"),
                        Vo(40, "div", 14),
                        fa(
                            41,
                            "* Note: This customizer web component is an online-only tool and is not part of the download package when purchasing the theme."
                        ),
                        Fo(),
                        Fo(),
                        Fo(),
                        Bo();
                }
                if (2 & t) {
                    const t = Uo();
                    Hs(22),
                        No("ngForOf", t.materialSwatches),
                        Hs(4),
                        No("ngForOf", t.palettes),
                        Hs(5),
                        No("icon", t.faRandom),
                        Hs(6),
                        No("icon", t.faFileDownload);
                }
            }
            const wf = function (t, e) {
                return { "sb-customizer-closed": t, "sb-customizer-open": e };
            };
            let Cf = (() => {
                    class t {
                        constructor(t, e) {
                            (this.sassService = t),
                                (this.changeDetectorRef = e),
                                (this.selectedSwatchIndex = 0),
                                (this.customColorsSelected = !1),
                                (this.faCog = jh),
                                (this.faCheck = Fh),
                                (this.faFileDownload = zh),
                                (this.faRandom = Bh),
                                (this.sbProSwatches = Yh),
                                (this.materialSwatches = Gh),
                                (this.palettes = Zh),
                                (this.closed = !0),
                                (this.colors = {
                                    primary: "",
                                    secondary: "",
                                    success: "",
                                    info: "",
                                    warning: "",
                                    danger: "",
                                }),
                                (this.status = {
                                    method: "swatch",
                                    index: 0,
                                    loading: !1,
                                    active: !1,
                                }),
                                (this.onChange = Uh()((t, e, n) => {
                                    (this.customColorsSelected = !0),
                                        (this.colors[e.id] = t),
                                        (this.status.method = "palette"),
                                        (this.status.index = n),
                                        (this.status.active = !1),
                                        (this.status.loading = !0),
                                        this.changeDetectorRef.detectChanges(),
                                        (this._startTime = Date.now()),
                                        this.sassService.updateColorsOverrides({
                                            colors: this.colors,
                                            theme: this.project,
                                        }),
                                        Lh()("event", "Color Selector", {
                                            event_category: "Customizer",
                                            event_label: this.project,
                                        });
                                }, 200));
                        }
                        randomPalette() {
                            (this.customColorsSelected = !0),
                                (this.status.method = "random"),
                                (this.status.active = !1),
                                (this.status.loading = !0);
                            const t = Kh()(3, {
                                clustering: "force-vector",
                                quality: 100,
                            });
                            (this.colors.primary = t[0]),
                                (this.colors.secondary = t[1]),
                                (this.colors.info = t[2]),
                                (this._startTime = Date.now()),
                                this.sassService.updateColorsOverrides({
                                    colors: this.colors,
                                    theme: this.project,
                                }),
                                Lh()("event", "Random Palette", {
                                    event_category: "Customizer",
                                    event_label: this.project,
                                });
                        }
                        ngOnInit() {
                            switch (this.project) {
                                case "sb-admin-pro":
                                case "sb-admin-pro-angular":
                                case "sb-ui-kit-pro":
                                case "sb-ui-kit-pro-angular":
                                    this.designLanguageMode = "sb-pro";
                                    break;
                                case "material-admin-pro":
                                    this.designLanguageMode = "material-pro";
                                    break;
                                default:
                                    throw new Error(
                                        `PROJECT_NOT_RECOGNIZED_FOR_DESIGN_LANGUAGE_MODE: ${this.project}`
                                    );
                            }
                            this.sassService.appended$.subscribe((t) => {
                                (this.status.loading = !1),
                                    (this.status.active = t),
                                    this.changeDetectorRef.detectChanges(),
                                    Lh()("event", "New CSS Appended", {
                                        event_category: "Customizer",
                                        event_label: this.project,
                                        value: Date.now() - this._startTime,
                                    });
                            }),
                                Object(Hh.install)("UA-38417733-31");
                        }
                        ngAfterViewInit() {
                            this.colorPickers.forEach((t) => {
                                const e = this._rgbToHex(
                                    window.getComputedStyle(t.nativeElement)
                                        .backgroundColor
                                );
                                this.colors[t.nativeElement.dataset.paletteId] =
                                    e;
                            });
                        }
                        _rgbToHex(t) {
                            const e = t.match(
                                /rgb\((\d+),\W*(\d+),\W*(\d+)\)$/
                            );
                            if (e)
                                return (
                                    "#" +
                                    (
                                        (1 << 24) +
                                        (parseInt(e[1], 10) << 16) +
                                        (parseInt(e[2], 10) << 8) +
                                        parseInt(e[3], 10)
                                    )
                                        .toString(16)
                                        .slice(1)
                                );
                        }
                        getPaletteId(t) {
                            return this.palettes[t].id;
                        }
                        toggle() {
                            this.closed = !this.closed;
                        }
                        setToSwatch(t, e) {
                            (this.customColorsSelected = !1),
                                (this.selectedSwatchIndex = e),
                                this.status.loading ||
                                    ((this.status.method = "swatch"),
                                    (this.status.index = e),
                                    (this.status.active = !1),
                                    (this.status.loading = !0),
                                    (this.colors = Object.assign({}, t.colors)),
                                    (this._startTime = Date.now()),
                                    this.sassService.updateColorsOverrides({
                                        colors: t.colors,
                                        theme: this.project,
                                        cache: !0,
                                    }),
                                    Lh()("event", "Set to Swatch", {
                                        event_category: "Customizer",
                                        event_label: this.project,
                                    }));
                        }
                        exportOverrides() {
                            return (function (t, e, n, r) {
                                return new (n || (n = Promise))(function (
                                    e,
                                    s
                                ) {
                                    function i(t) {
                                        try {
                                            a(r.next(t));
                                        } catch (_f) {
                                            s(_f);
                                        }
                                    }
                                    function o(t) {
                                        try {
                                            a(r.throw(t));
                                        } catch (_f) {
                                            s(_f);
                                        }
                                    }
                                    function a(t) {
                                        var r;
                                        t.done
                                            ? e(t.value)
                                            : ((r = t.value),
                                              r instanceof n
                                                  ? r
                                                  : new n(function (t) {
                                                        t(r);
                                                    })).then(i, o);
                                    }
                                    a((r = r.apply(t, [])).next());
                                });
                            })(this, 0, void 0, function* () {
                                const t =
                                        this.sassService.generateVariableOverridesFile(
                                            {
                                                colors: this.colors,
                                                theme: this.project,
                                            }
                                        ),
                                    e = new Blob([t], { type: "text/plain" }),
                                    n = document.createElement("a");
                                (n.download =
                                    "variables-colors-overrides.scss"),
                                    (n.href = window.URL.createObjectURL(e)),
                                    n.click(),
                                    Lh()("event", "Export Overrides", {
                                        event_category: "Customizer",
                                        event_label: this.project,
                                    });
                            });
                        }
                        changeThemeType(t) {
                            const e = document.getElementsByTagName("nav");
                            switch (
                                (e[0].classList.remove(
                                    "bg-dark",
                                    "bg-light",
                                    "bg-primary"
                                ),
                                e[0].classList.remove(
                                    "navbar-dark",
                                    "navbar-light",
                                    "navbar-primary"
                                ),
                                t)
                            ) {
                                case "light":
                                    e[0].classList.add("bg-light"),
                                        e[0].classList.add("navbar-light");
                                    break;
                                case "dark":
                                    e[0].classList.add("bg-dark"),
                                        e[0].classList.add("navbar-dark");
                                    break;
                                case "primary":
                                    e[0].classList.add("bg-primary"),
                                        e[0].classList.add("navbar-dark");
                            }
                            const n = () => {
                                    const t =
                                        r.getElementsByClassName("text-black");
                                    for (const e of Array.from(t))
                                        e.classList.remove("text-black"),
                                            e.classList.add("text-white");
                                },
                                r =
                                    document.getElementsByTagName("main")[0]
                                        .children[0];
                            if (!r) throw new Error("HEADER_ELEMENT_NOT_FOUND");
                            if (
                                r.classList.contains("bg-dark") ||
                                r.classList.contains("bg-light") ||
                                r.classList.contains("bg-primary")
                            )
                                switch (
                                    (r.classList.remove(
                                        "bg-dark",
                                        "bg-light",
                                        "bg-primary"
                                    ),
                                    t)
                                ) {
                                    case "light":
                                        r.classList.add("bg-light"),
                                            (() => {
                                                const t =
                                                    r.getElementsByClassName(
                                                        "text-white"
                                                    );
                                                for (const e of Array.from(t))
                                                    e.classList.remove(
                                                        "text-white"
                                                    ),
                                                        e.classList.add(
                                                            "text-black"
                                                        );
                                            })();
                                        break;
                                    case "dark":
                                        r.classList.add("bg-dark"), n();
                                        break;
                                    case "primary":
                                        r.classList.add("bg-primary"), n();
                                }
                        }
                    }
                    return (
                        (t.ɵfac = function (e) {
                            return new (e || t)(Ro(Vh), Ro(rl));
                        }),
                        (t.ɵcmp = Dt({
                            type: t,
                            selectors: [["ng-component"]],
                            viewQuery: function (t, e) {
                                if ((1 & t && Ul(of, 1), 2 & t)) {
                                    let t;
                                    Wl((t = Zl())) && (e.colorPickers = t);
                                }
                            },
                            inputs: { project: "project" },
                            decls: 5,
                            vars: 8,
                            consts: [
                                [
                                    "id",
                                    "style-switcher",
                                    1,
                                    "sb-customizer",
                                    3,
                                    "ngClass",
                                ],
                                [1, "sb-customizer-toggler", 3, "click"],
                                [3, "icon", "spin"],
                                [4, "ngIf"],
                                [1, "sb-customizer-heading", "shadow"],
                                [
                                    1,
                                    "sb-customizer-content",
                                    "d-flex",
                                    "flex-column",
                                    "justify-content-between",
                                ],
                                [1, "sb-customizer-subheading"],
                                [1, "sb-customizer-content-swatches", "mb-4"],
                                [4, "ngFor", "ngForOf"],
                                ["id", "chooser", 1, "mb-4"],
                                [
                                    "class",
                                    "btn-customizer",
                                    "type",
                                    "button",
                                    "cpPosition",
                                    "top-left",
                                    3,
                                    "ngClass",
                                    "colorPicker",
                                    "colorPickerChange",
                                    4,
                                    "ngFor",
                                    "ngForOf",
                                ],
                                [
                                    1,
                                    "btn-customizer",
                                    "btn",
                                    "btn-outline-dark",
                                    3,
                                    "click",
                                ],
                                [3, "icon"],
                                [
                                    1,
                                    "btn-customizer",
                                    "btn",
                                    "btn-outline-primary",
                                    "mb-0",
                                    3,
                                    "click",
                                ],
                                [
                                    1,
                                    "sb-customizer-notice",
                                    "small",
                                    "text-muted",
                                ],
                                [1, "btn-customizer", "swatch", 3, "click"],
                                [3, "icon", 4, "ngIf"],
                                [
                                    "class",
                                    "spinner-border spinner-border-sm",
                                    "role",
                                    "status",
                                    "aria-hidden",
                                    "true",
                                    4,
                                    "ngIf",
                                ],
                                [
                                    "role",
                                    "status",
                                    "aria-hidden",
                                    "true",
                                    1,
                                    "spinner-border",
                                    "spinner-border-sm",
                                ],
                                [
                                    "type",
                                    "button",
                                    "cpPosition",
                                    "top-left",
                                    1,
                                    "btn-customizer",
                                    3,
                                    "ngClass",
                                    "colorPicker",
                                    "colorPickerChange",
                                ],
                                ["colorPicker", ""],
                                [1, "text-white-50"],
                                [1, "row", "mb-4"],
                                [1, "col-4"],
                                [
                                    "type",
                                    "button",
                                    1,
                                    "btn",
                                    "btn-sm",
                                    "btn-light",
                                    3,
                                    "click",
                                ],
                                [
                                    "type",
                                    "button",
                                    1,
                                    "btn",
                                    "btn-sm",
                                    "btn-dark",
                                    3,
                                    "click",
                                ],
                                [
                                    "type",
                                    "button",
                                    1,
                                    "btn",
                                    "btn-sm",
                                    "btn-primary",
                                    3,
                                    "click",
                                ],
                                [1, "mb-4", "d-flex", "flex-wrap"],
                                [
                                    "class",
                                    "pronto-swatch m-2",
                                    "tabindex",
                                    "0",
                                    3,
                                    "ngClass",
                                    "keyup.enter",
                                    "click",
                                    4,
                                    "ngFor",
                                    "ngForOf",
                                ],
                                [
                                    "tabindex",
                                    "0",
                                    1,
                                    "pronto-swatch",
                                    "m-2",
                                    3,
                                    "ngClass",
                                    "keyup.enter",
                                    "click",
                                ],
                                [1, "pronto-swatch-colors"],
                                [1, "pronto-swatch-primary"],
                                [1, "pronto-swatch-secondary"],
                            ],
                            template: function (t, e) {
                                var n, r, s, i, o;
                                1 & t &&
                                    (Vo(0, "div", 0),
                                    Vo(1, "button", 1),
                                    qo("click", function () {
                                        return e.toggle();
                                    }),
                                    jo(2, "fa-icon", 2),
                                    Fo(),
                                    lo(3, pf, 28, 4, "ng-container", 3),
                                    lo(4, bf, 42, 4, "ng-container", 3),
                                    Fo()),
                                    2 & t &&
                                        (No(
                                            "ngClass",
                                            ((n = 5),
                                            (r = wf),
                                            (s = e.closed),
                                            (i = !e.closed),
                                            (function (t, e, n, r, s, i, o) {
                                                const a = e + n;
                                                return (function (t, e, n, r) {
                                                    const s = io(t, e, n);
                                                    return io(t, e + 1, r) || s;
                                                })(t, a, s, i)
                                                    ? so(
                                                          t,
                                                          a + 2,
                                                          o
                                                              ? r.call(o, s, i)
                                                              : r(s, i)
                                                      )
                                                    : Sl(t, a + 2);
                                            })(ke(), Ne(), n, r, s, i, o))
                                        ),
                                        Hs(2),
                                        No("icon", e.faCog)("spin", !0),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            "sb-pro" === e.designLanguageMode
                                        ),
                                        Hs(1),
                                        No(
                                            "ngIf",
                                            "material-pro" ===
                                                e.designLanguageMode
                                        ));
                            },
                            directives: [Yc, pp, Qc, Xc, nf],
                            pipes: [sf],
                            styles: [
                                ".btn-customizer[_ngcontent-%COMP%]{display:flex;width:100%;justify-content:space-between;align-items:center;border-radius:.35rem;font-size:.85rem;padding:1rem;outline:0;margin-bottom:.5rem}.btn-customizer[_ngcontent-%COMP%]   svg[_ngcontent-%COMP%]{visibility:hidden}.btn-customizer[_ngcontent-%COMP%]:focus{font-weight:700;box-shadow:0 0 0 .125rem #d7dce3}.btn-customizer[_ngcontent-%COMP%]:focus   svg[_ngcontent-%COMP%]{visibility:visible}.sb-customizer-btn-export[_ngcontent-%COMP%]{font-size:.85rem;padding:1rem}.sb-customizer-btn-export[_ngcontent-%COMP%]   .ng-fa-icon[_ngcontent-%COMP%]{margin-right:.25rem}.sb-customizer[_ngcontent-%COMP%]{z-index:9999;position:fixed;top:0;width:20rem;height:100vh;text-align:left;background:#fff;transition:right .5s;box-shadow:-.15rem 0 1.75rem 0 rgba(34,39,46,.15)}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-heading[_ngcontent-%COMP%]{padding:1.5rem;font-size:.7rem;font-weight:800;text-transform:uppercase;letter-spacing:.05em;color:#a7aeb8}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-subheading[_ngcontent-%COMP%]{font-size:.8rem;font-style:italic;color:#6c737d;margin-bottom:.75rem}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-toggler[_ngcontent-%COMP%]{position:absolute;top:4.625rem;display:flex;align-items:center;justify-content:center;left:-3rem;width:3rem;height:3rem;border-top-left-radius:.35rem;border-bottom-left-radius:.35rem;border-top-right-radius:0;border-bottom-right-radius:0;border:0;box-shadow:0 .15rem 1.75rem 0 rgba(34,39,46,.15);color:#001500;background-color:#fff}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-toggler[_ngcontent-%COMP%]:focus{outline:none}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]{position:relative;height:calc(100% - 64px);overflow-y:auto;padding:1.5rem}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]::-webkit-scrollbar{display:block;width:.5rem}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]::-webkit-scrollbar-thumb{background-color:#c7cdd6;border-radius:10rem;height:3em;border:.1rem solid transparent;background-clip:padding-box}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]::-webkit-scrollbar-track{background-color:rgba(34,39,46,.05)}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]::-webkit-scrollbar-button{width:0;height:0;display:none}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]::-webkit-scrollbar-corner{background-color:transparent}.sb-customizer[_ngcontent-%COMP%]   .sb-customizer-content[_ngcontent-%COMP%]:hover::-webkit-scrollbar{display:block}.sb-customizer.sb-customizer-closed[_ngcontent-%COMP%]{right:-20rem}.sb-customizer.sb-customizer-open[_ngcontent-%COMP%]{right:0}.swatch[_ngcontent-%COMP%]{border:0}#swatch1[_ngcontent-%COMP%]   .swatch[_ngcontent-%COMP%]{color:#fff;background-color:#0061f2;background-image:linear-gradient(45deg,#0061f2,#6900c7)}#swatch2[_ngcontent-%COMP%]   .swatch[_ngcontent-%COMP%]{color:#fff;background-color:#1da1f5;background-image:linear-gradient(45deg,#1da1f5,#8039da)}#swatch3[_ngcontent-%COMP%]   .swatch[_ngcontent-%COMP%]{color:#fff;background-color:#f53b57;background-image:linear-gradient(45deg,#f53b57,#ff793f)}#swatch4[_ngcontent-%COMP%]   .swatch[_ngcontent-%COMP%]{color:#fff;background-color:#6eabc2;background-image:linear-gradient(45deg,#6eabc2,#506c6a)}#swatch5[_ngcontent-%COMP%]   .swatch[_ngcontent-%COMP%]{color:#fff;background-color:#06794f;background-image:linear-gradient(45deg,#06794f,#0fa28b)}.sb-customizer-notice[_ngcontent-%COMP%]{line-height:1.1;font-style:italic}.pronto-swatch[_ngcontent-%COMP%]{height:2.5rem;width:2.5rem;border-radius:100%;overflow:hidden;display:inline-flex;flex-shrink:0;cursor:pointer;border:.125rem solid transparent}.pronto-swatch[_ngcontent-%COMP%]   .pronto-swatch-colors[_ngcontent-%COMP%]{display:flex;height:100%;width:100%;transform:rotate(45deg)}.pronto-swatch[_ngcontent-%COMP%]   .pronto-swatch-colors[_ngcontent-%COMP%]   .pronto-swatch-primary[_ngcontent-%COMP%], .pronto-swatch[_ngcontent-%COMP%]   .pronto-swatch-colors[_ngcontent-%COMP%]   .pronto-swatch-secondary[_ngcontent-%COMP%]{height:100%;width:50%}.pronto-swatch[_ngcontent-%COMP%]   .pronto-swatch-colors[_ngcontent-%COMP%]   .pronto-swatch-primary[_ngcontent-%COMP%]{background-color:#1abc9c}.pronto-swatch[_ngcontent-%COMP%]   .pronto-swatch-colors[_ngcontent-%COMP%]   .pronto-swatch-secondary[_ngcontent-%COMP%]{background-color:#2c3e50}.pronto-swatch.selected[_ngcontent-%COMP%], .pronto-swatch.selected[_ngcontent-%COMP%]:active, .pronto-swatch.selected[_ngcontent-%COMP%]:focus{box-shadow:0 0 0 .4rem rgba(0,21,0,.5)}.pronto-swatch[_ngcontent-%COMP%]:active, .pronto-swatch[_ngcontent-%COMP%]:focus{box-shadow:0 0 0 .4rem rgba(0,21,0,.25)}.pronto-swatch[_ngcontent-%COMP%]:focus{outline:none}",
                            ],
                            changeDetection: 0,
                        })),
                        t
                    );
                })(),
                xf = (() => {
                    class t {
                        constructor(t) {
                            this.injector = t;
                        }
                        ngDoBootstrap() {
                            const t = (function (t, e) {
                                const n = (function (t, e) {
                                        return e
                                            .get(Ia)
                                            .resolveComponentFactory(t).inputs;
                                    })(t, e.injector),
                                    r =
                                        e.strategyFactory ||
                                        new Ph(t, e.injector),
                                    s = (function (t) {
                                        const e = {};
                                        return (
                                            t.forEach(
                                                ({
                                                    propName: t,
                                                    templateName: n,
                                                }) => {
                                                    var r;
                                                    e[
                                                        ((r = n),
                                                        r.replace(
                                                            /[A-Z]/g,
                                                            (t) =>
                                                                `-${t.toLowerCase()}`
                                                        ))
                                                    ] = t;
                                                }
                                            ),
                                            e
                                        );
                                    })(n);
                                class i extends Nh {
                                    constructor(t) {
                                        super(), (this.injector = t);
                                    }
                                    get ngElementStrategy() {
                                        if (!this._ngElementStrategy) {
                                            const t = (this._ngElementStrategy =
                                                r.create(
                                                    this.injector || e.injector
                                                ));
                                            n.forEach(({ propName: e }) => {
                                                if (!this.hasOwnProperty(e))
                                                    return;
                                                const n = this[e];
                                                delete this[e],
                                                    t.setInputValue(e, n);
                                            });
                                        }
                                        return this._ngElementStrategy;
                                    }
                                    attributeChangedCallback(t, e, n, r) {
                                        this.ngElementStrategy.setInputValue(
                                            s[t],
                                            n
                                        );
                                    }
                                    connectedCallback() {
                                        let t = !1;
                                        this.ngElementStrategy.events &&
                                            (this.subscribeToEvents(),
                                            (t = !0)),
                                            this.ngElementStrategy.connect(
                                                this
                                            ),
                                            t || this.subscribeToEvents();
                                    }
                                    disconnectedCallback() {
                                        this._ngElementStrategy &&
                                            this._ngElementStrategy.disconnect(),
                                            this.ngElementEventsSubscription &&
                                                (this.ngElementEventsSubscription.unsubscribe(),
                                                (this.ngElementEventsSubscription =
                                                    null));
                                    }
                                    subscribeToEvents() {
                                        this.ngElementEventsSubscription =
                                            this.ngElementStrategy.events.subscribe(
                                                (t) => {
                                                    const e = (function (
                                                        t,
                                                        e,
                                                        n
                                                    ) {
                                                        if (
                                                            "function" !=
                                                            typeof CustomEvent
                                                        ) {
                                                            const r =
                                                                t.createEvent(
                                                                    "CustomEvent"
                                                                );
                                                            return (
                                                                r.initCustomEvent(
                                                                    e,
                                                                    !1,
                                                                    !1,
                                                                    n
                                                                ),
                                                                r
                                                            );
                                                        }
                                                        return new CustomEvent(
                                                            e,
                                                            {
                                                                bubbles: !1,
                                                                cancelable: !1,
                                                                detail: n,
                                                            }
                                                        );
                                                    })(
                                                        this.ownerDocument,
                                                        t.name,
                                                        t.value
                                                    );
                                                    this.dispatchEvent(e);
                                                }
                                            );
                                    }
                                }
                                return (
                                    (i.observedAttributes = Object.keys(s)),
                                    n.forEach(({ propName: t }) => {
                                        Object.defineProperty(i.prototype, t, {
                                            get() {
                                                return this.ngElementStrategy.getInputValue(
                                                    t
                                                );
                                            },
                                            set(e) {
                                                this.ngElementStrategy.setInputValue(
                                                    t,
                                                    e
                                                );
                                            },
                                            configurable: !0,
                                            enumerable: !0,
                                        });
                                    }),
                                    i
                                );
                            })(Cf, { injector: this.injector });
                            customElements.get("sb-customizer") ||
                                customElements.define("sb-customizer", t);
                        }
                    }
                    return (
                        (t.ɵmod = zt({ type: t })),
                        (t.ɵinj = it({
                            factory: function (e) {
                                return new (e || t)(sr(Ji));
                            },
                            providers: [Vh],
                            imports: [[Mu, dh, fp, rf]],
                        })),
                        t
                    );
                })();
            (function () {
                if (Sc)
                    throw new Error(
                        "Cannot enable prod mode after platform setup."
                    );
                Tc = !1;
            })(),
                Su()
                    .bootstrapModule(xf)
                    .catch((t) => console.error(t));
        },
        AP2z: function (t, e, n) {
            var r = n("nmnc"),
                s = Object.prototype,
                i = s.hasOwnProperty,
                o = s.toString,
                a = r ? r.toStringTag : void 0;
            t.exports = function (t) {
                var e = i.call(t, a),
                    n = t[a];
                try {
                    t[a] = void 0;
                    var r = !0;
                } catch (l) {}
                var s = o.call(t);
                return r && (e ? (t[a] = n) : delete t[a]), s;
            };
        },
        ExA7: function (t, e) {
            t.exports = function (t) {
                return null != t && "object" == typeof t;
            };
        },
        GoyQ: function (t, e) {
            t.exports = function (t) {
                var e = typeof t;
                return null != t && ("object" == e || "function" == e);
            };
        },
        KdVd: function (t, e, n) {
            var r = n("sVnn"),
                s = {
                    protanope: {
                        x: 0.7465,
                        y: 0.2535,
                        m: 1.273463,
                        yint: -0.073894,
                    },
                    deuteranope: {
                        x: 1.4,
                        y: -0.4,
                        m: 0.968437,
                        yint: 0.003331,
                    },
                    tritanope: { x: 0.1748, y: 0, m: 0.062921, yint: 0.292119 },
                };
            function i() {
                this.cache = {};
            }
            (i.prototype.simulate = function (t, e, n) {
                n = n || 1;
                var i = t.join("-") + "-" + e + "-" + n,
                    o = this.cache[i];
                if (o) return o;
                var a = s[e].x,
                    l = s[e].y,
                    c = s[e].m,
                    u = s[e].yint,
                    h = r.labToRgb(t),
                    d = h[0],
                    p = h[1],
                    f = h[2],
                    g = d,
                    m = p,
                    y = f,
                    v = Math.pow(d, 2.2),
                    b = Math.pow(p, 2.2),
                    w = Math.pow(f, 2.2),
                    C = 0.412424 * v + 0.357579 * b + 0.180464 * w,
                    x = 0.212656 * v + 0.715158 * b + 0.0721856 * w,
                    _ = 0.0193324 * v + 0.119193 * b + 0.950444 * w,
                    k = C / (C + x + _),
                    A = x / (C + x + _),
                    E = (A - l) / (k - a),
                    I = A - k * E,
                    T = (u - I) / (E - c),
                    S = E * T + I,
                    O = (0.312713 * x) / 0.329016 - (C = (T * x) / S),
                    M =
                        (0.358271 * x) / 0.329016 -
                        (_ = ((1 - (T + S)) * x) / S),
                    P = 3.24071 * O + -0.498571 * M,
                    R = -0.969258 * O + 0.0415557 * M,
                    N = 0.0556352 * O + 1.05707 * M,
                    D =
                        (((g = 3.24071 * C + -1.53726 * x + -0.498571 * _) < 0
                            ? 0
                            : 1) -
                            g) /
                        P,
                    V =
                        (((m = -0.969258 * C + 1.87599 * x + 0.0415557 * _) < 0
                            ? 0
                            : 1) -
                            m) /
                        R,
                    F =
                        (((y = 0.0556352 * C + -0.203996 * x + 1.05707 * _) < 0
                            ? 0
                            : 1) -
                            y) /
                        N,
                    j = Math.max(
                        D > 1 || D < 0 ? 0 : D,
                        V > 1 || V < 0 ? 0 : V,
                        F > 1 || F < 0 ? 0 : F
                    );
                (g += j * P),
                    (m += j * R),
                    (y += j * N),
                    (g = Math.pow(g, 1 / 2.2)),
                    (m = Math.pow(m, 1 / 2.2)),
                    (y = Math.pow(y, 1 / 2.2));
                var z = r.rgbToLab([
                    (g = d * (1 - n) + g * n),
                    (m = p * (1 - n) + m * n),
                    (y = f * (1 - n) + y * n),
                ]);
                return (this.cache[i] = z), z;
            }),
                (i.prototype.euclidean = function (t, e) {
                    return Math.sqrt(
                        Math.pow(t[0] - e[0], 2) +
                            Math.pow(t[1] - e[1], 2) +
                            Math.pow(t[2] - e[2], 2)
                    );
                }),
                (i.prototype.cmc = function (t, e, n, r) {
                    for (
                        var s = n[0],
                            i = r[0],
                            o = n[1],
                            a = r[1],
                            l = n[2],
                            c = r[2],
                            u = Math.sqrt(Math.pow(o, 2) + Math.pow(l, 2)),
                            h = u - Math.sqrt(Math.pow(a, 2) + Math.pow(c, 2)),
                            d = s - i,
                            p = l - c,
                            f = Math.sqrt(
                                Math.pow(o - a, 2) +
                                    Math.pow(p, 2) +
                                    Math.pow(h, 2)
                            ),
                            g = Math.atan2(l, o) * (180 / Math.PI);
                        g < 0;

                    )
                        g += 360;
                    var m = Math.sqrt(Math.pow(u, 4) / (Math.pow(u, 4) + 1900)),
                        y = (0.0638 * u) / (1 + 0.0131 * u) + 0.638,
                        v =
                            y *
                            (m *
                                (g >= 164 && g <= 345
                                    ? 0.56 + Math.abs(0.2 * Math.cos(g + 168))
                                    : 0.36 + Math.abs(0.4 * Math.cos(g + 35))) +
                                1 -
                                m);
                    return Math.sqrt(
                        Math.pow(
                            d /
                                (t *
                                    (n[0] < 16
                                        ? 0.511
                                        : (0.040975 * s) / (1 + 0.01765 * s))),
                            2
                        ) +
                            Math.pow(h / (e * y), 2) +
                            Math.pow(f / v, 2)
                    );
                }.bind(null, 2, 1)),
                (i.prototype.colorblind = function (t, e, n) {
                    return (
                        (e = this.simulate(e, t)),
                        (n = this.simulate(n, t)),
                        this.cmc(e, n)
                    );
                }),
                Object.keys(s).forEach(function (t) {
                    i.prototype[t] = function (e, n) {
                        return this.colorblind(t, e, n);
                    };
                }),
                (i.prototype.compromise = function (t, e) {
                    var n = 0,
                        r = this.cmc(t, e);
                    return (
                        (n += 1e3 * r),
                        (r = this.colorblind("protanope", t, e)),
                        isNaN(r) || (n += 100 * r),
                        (r = this.colorblind("deuteranope", t, e)),
                        isNaN(r) || (n += 500 * r),
                        (r = this.colorblind("tritanope", t, e)),
                        isNaN(r) || (n += 1 * r),
                        n / 1601
                    );
                }),
                (i.prototype.get = function (t) {
                    return t in s
                        ? this.colorblind.bind(this, t)
                        : this[t].bind(this);
                }),
                (t.exports = i);
        },
        KfNM: function (t, e) {
            var n = Object.prototype.toString;
            t.exports = function (t) {
                return n.call(t);
            };
        },
        Kz5y: function (t, e, n) {
            var r = n("WFqU"),
                s =
                    "object" == typeof self &&
                    self &&
                    self.Object === Object &&
                    self,
                i = r || s || Function("return this")();
            t.exports = i;
        },
        LCQ0: function (t, e) {
            t.exports = {
                all: [0, 360, 0, 100, 0, 100],
                default: [0, 360, 30, 80, 35, 80],
                colorblind: [0, 360, 40, 70, 15, 85],
                "fancy-light": [0, 360, 15, 40, 70, 100],
                "fancy-dark": [0, 360, 8, 40, 7, 40],
                shades: [0, 240, 0, 15, 0, 100],
                tarnish: [0, 360, 0, 15, 30, 70],
                pastel: [0, 360, 0, 30, 70, 100],
                pimp: [0, 360, 30, 100, 25, 70],
                intense: [0, 360, 20, 100, 15, 80],
                fluo: [0, 300, 35, 100, 75, 100],
                "red-roses": [330, 20, 10, 100, 35, 100],
                "ochre-sand": [20, 60, 20, 50, 35, 100],
                "yellow-lime": [60, 90, 10, 100, 35, 100],
                "green-mint": [90, 150, 10, 100, 35, 100],
                "ice-cube": [150, 200, 0, 100, 35, 100],
                "blue-ocean": [220, 260, 8, 80, 0, 50],
                "indigo-night": [260, 290, 40, 100, 35, 100],
                "purple-wine": [290, 330, 0, 100, 0, 40],
            };
        },
        MSY3: function (t, e) {
            function n(t) {
                var e;
                t ||
                    ((e = Math.pow(2, 31) - 1),
                    (t = 0 + Math.floor(Math.random() * (e - 0 + 1)))),
                    (this.seed = t % 2147483647),
                    this.seed <= 0 && (this.seed += 2147483646);
            }
            (n.prototype.next = function () {
                return (
                    (this.seed = (16807 * this.seed) % 2147483647), this.seed
                );
            }),
                (n.prototype.nextFloat = function () {
                    return (this.next() - 1) / 2147483646;
                }),
                (t.exports = n);
        },
        NykK: function (t, e, n) {
            var r = n("nmnc"),
                s = n("AP2z"),
                i = n("KfNM"),
                o = r ? r.toStringTag : void 0;
            t.exports = function (t) {
                return null == t
                    ? void 0 === t
                        ? "[object Undefined]"
                        : "[object Null]"
                    : o && o in Object(t)
                    ? s(t)
                    : i(t);
            };
        },
        QIyF: function (t, e, n) {
            var r = n("Kz5y");
            t.exports = function () {
                return r.Date.now();
            };
        },
        WFqU: function (t, e) {
            var n =
                "object" == typeof global &&
                global &&
                global.Object === Object &&
                global;
            t.exports = n;
        },
        nmnc: function (t, e, n) {
            var r = n("Kz5y");
            t.exports = r.Symbol;
        },
        sEfC: function (t, e, n) {
            var r = n("GoyQ"),
                s = n("QIyF"),
                i = n("tLB3"),
                o = Math.max,
                a = Math.min;
            t.exports = function (t, e, n) {
                var l,
                    c,
                    u,
                    h,
                    d,
                    p,
                    f = 0,
                    g = !1,
                    m = !1,
                    y = !0;
                if ("function" != typeof t)
                    throw new TypeError("Expected a function");
                function v(e) {
                    var n = l,
                        r = c;
                    return (l = c = void 0), (f = e), (h = t.apply(r, n));
                }
                function b(t) {
                    return (f = t), (d = setTimeout(C, e)), g ? v(t) : h;
                }
                function w(t) {
                    var n = t - p;
                    return void 0 === p || n >= e || n < 0 || (m && t - f >= u);
                }
                function C() {
                    var t = s();
                    if (w(t)) return x(t);
                    d = setTimeout(
                        C,
                        (function (t) {
                            var n = e - (t - p);
                            return m ? a(n, u - (t - f)) : n;
                        })(t)
                    );
                }
                function x(t) {
                    return (d = void 0), y && l ? v(t) : ((l = c = void 0), h);
                }
                function _() {
                    var t = s(),
                        n = w(t);
                    if (((l = arguments), (c = this), (p = t), n)) {
                        if (void 0 === d) return b(p);
                        if (m)
                            return (
                                clearTimeout(d), (d = setTimeout(C, e)), v(p)
                            );
                    }
                    return void 0 === d && (d = setTimeout(C, e)), h;
                }
                return (
                    (e = i(e) || 0),
                    r(n) &&
                        ((g = !!n.leading),
                        (u = (m = "maxWait" in n)
                            ? o(i(n.maxWait) || 0, e)
                            : u),
                        (y = "trailing" in n ? !!n.trailing : y)),
                    (_.cancel = function () {
                        void 0 !== d && clearTimeout(d),
                            (f = 0),
                            (l = p = c = d = void 0);
                    }),
                    (_.flush = function () {
                        return void 0 === d ? h : x(s());
                    }),
                    _
                );
            };
        },
        sVnn: function (t, e) {
            function n(t) {
                return Math.round(
                    255 *
                        (t <= 0.00304
                            ? 12.92 * t
                            : 1.055 * Math.pow(t, 1 / 2.4) - 0.055)
                );
            }
            function r(t) {
                return (t /= 255) <= 0.04045
                    ? t / 12.92
                    : Math.pow((t + 0.055) / 1.055, 2.4);
            }
            function s(t) {
                return t > 0.008856452
                    ? Math.pow(t, 1 / 3)
                    : t / 0.12841855 + 0.137931034;
            }
            function i(t) {
                return t > 0.206896552
                    ? t * t * t
                    : 0.12841855 * (t - 0.137931034);
            }
            function o(t) {
                var e = t[1],
                    r = t[2],
                    s = (t[0] + 16) / 116,
                    o = isNaN(e) ? s : s + e / 500,
                    a = isNaN(r) ? s : s - r / 200;
                return (
                    (s = 1 * i(s)),
                    [
                        n(
                            3.2404542 * (o = 0.95047 * i(o)) -
                                1.5371385 * s -
                                0.4985314 * (a = 1.08883 * i(a))
                        ),
                        n(-0.969266 * o + 1.8760108 * s + 0.041556 * a),
                        (r = n(0.0556434 * o - 0.2040259 * s + 1.0572252 * a)),
                    ]
                );
            }
            function a(t) {
                return ("0" + t.toString(16)).slice(-2);
            }
            var l = 180 / Math.PI;
            (e.validateRgb = function (t) {
                var e = t[0],
                    n = t[1],
                    r = t[2];
                return (
                    e >= 0 &&
                    e <= 255 &&
                    n >= 0 &&
                    n <= 255 &&
                    r >= 0 &&
                    r <= 255
                );
            }),
                (e.labToRgb = o),
                (e.labToRgbHex = function (t) {
                    var e = o(t);
                    return "#" + a(e[0]) + a(e[1]) + a(e[2]);
                }),
                (e.rgbToLab = function (t) {
                    var e = (function (t) {
                            var e = t[0],
                                n = t[1],
                                i = t[2];
                            return [
                                s(
                                    (0.4124564 * (e = r(e)) +
                                        0.3575761 * (n = r(n)) +
                                        0.1804375 * (i = r(i))) /
                                        0.95047
                                ),
                                s(
                                    (0.2126729 * e +
                                        0.7151522 * n +
                                        0.072175 * i) /
                                        1
                                ),
                                s(
                                    (0.0193339 * e +
                                        0.119192 * n +
                                        0.9503041 * i) /
                                        1.08883
                                ),
                            ];
                        })(t),
                        n = e[1],
                        i = 116 * n - 16;
                    return [i < 0 ? 0 : i, 500 * (e[0] - n), 200 * (n - e[2])];
                }),
                (e.labToHcl = function (t) {
                    var e = t[0],
                        n = t[1],
                        r = t[2],
                        s = Math.sqrt(n * n + r * r),
                        i = (Math.atan2(r, n) * l + 360) % 360;
                    return 0 === Math.round(1e4 * s) && (i = NaN), [i, s, e];
                }),
                (e.diffSort = function (t, e) {
                    for (
                        var n, r, s, i, o, a, l = [(e = e.slice()).shift()];
                        e.length > 0;

                    ) {
                        for (n = -1, r = -1 / 0, s = 0; s < e.length; s++)
                            for (i = e[s], a = 0; a < l.length; a++)
                                (o = t(i, l[a])) > r && ((r = o), (n = s));
                        l.push(e[n]), e.splice(n, 1);
                    }
                    return l;
                });
        },
        tLB3: function (t, e, n) {
            var r = n("GoyQ"),
                s = n("/9aa"),
                i = /^\s+|\s+$/g,
                o = /^[-+]0x[0-9a-f]+$/i,
                a = /^0b[01]+$/i,
                l = /^0o[0-7]+$/i,
                c = parseInt;
            t.exports = function (t) {
                if ("number" == typeof t) return t;
                if (s(t)) return NaN;
                if (r(t)) {
                    var e = "function" == typeof t.valueOf ? t.valueOf() : t;
                    t = r(e) ? e + "" : e;
                }
                if ("string" != typeof t) return 0 === t ? t : +t;
                t = t.replace(i, "");
                var n = a.test(t);
                return n || l.test(t)
                    ? c(t.slice(2), n ? 2 : 8)
                    : o.test(t)
                    ? NaN
                    : +t;
            };
        },
        zn8P: function (t, e) {
            function n(t) {
                return Promise.resolve().then(function () {
                    var e = new Error("Cannot find module '" + t + "'");
                    throw ((e.code = "MODULE_NOT_FOUND"), e);
                });
            }
            (n.keys = function () {
                return [];
            }),
                (n.resolve = n),
                (t.exports = n),
                (n.id = "zn8P");
        },
    },
    [[0, 0]],
]);
(window.webpackJsonpSBCustomizer = window.webpackJsonpSBCustomizer || []).push([
    [2],
    {
        2: function (e, t, n) {
            e.exports = n("Xa9S");
        },
        Xa9S: function (e, t, n) {
            "use strict";
            n.r(t), n("pDpN");
        },
        pDpN: function (e, t) {
            !(function (e) {
                const t = e.performance;
                function n(e) {
                    t && t.mark && t.mark(e);
                }
                function o(e, n) {
                    t && t.measure && t.measure(e, n);
                }
                n("Zone");
                const r = e.__Zone_symbol_prefix || "__zone_symbol__";
                function s(e) {
                    return r + e;
                }
                const a = !0 === e[s("forceDuplicateZoneCheck")];
                if (e.Zone) {
                    if (a || "function" != typeof e.Zone.__symbol__)
                        throw new Error("Zone already loaded.");
                    return e.Zone;
                }
                class i {
                    constructor(e, t) {
                        (this._parent = e),
                            (this._name = t ? t.name || "unnamed" : "<root>"),
                            (this._properties = (t && t.properties) || {}),
                            (this._zoneDelegate = new l(
                                this,
                                this._parent && this._parent._zoneDelegate,
                                t
                            ));
                    }
                    static assertZonePatched() {
                        if (e.Promise !== O.ZoneAwarePromise)
                            throw new Error(
                                "Zone.js has detected that ZoneAwarePromise `(window|global).Promise` has been overwritten.\nMost likely cause is that a Promise polyfill has been loaded after Zone.js (Polyfilling Promise api is not necessary when zone.js is loaded. If you must load one, do so before loading zone.js.)"
                            );
                    }
                    static get root() {
                        let e = i.current;
                        for (; e.parent; ) e = e.parent;
                        return e;
                    }
                    static get current() {
                        return z.zone;
                    }
                    static get currentTask() {
                        return j;
                    }
                    static __load_patch(t, r) {
                        if (O.hasOwnProperty(t)) {
                            if (a) throw Error("Already loaded patch: " + t);
                        } else if (!e["__Zone_disable_" + t]) {
                            const s = "Zone:" + t;
                            n(s), (O[t] = r(e, i, C)), o(s, s);
                        }
                    }
                    get parent() {
                        return this._parent;
                    }
                    get name() {
                        return this._name;
                    }
                    get(e) {
                        const t = this.getZoneWith(e);
                        if (t) return t._properties[e];
                    }
                    getZoneWith(e) {
                        let t = this;
                        for (; t; ) {
                            if (t._properties.hasOwnProperty(e)) return t;
                            t = t._parent;
                        }
                        return null;
                    }
                    fork(e) {
                        if (!e) throw new Error("ZoneSpec required!");
                        return this._zoneDelegate.fork(this, e);
                    }
                    wrap(e, t) {
                        if ("function" != typeof e)
                            throw new Error("Expecting function got: " + e);
                        const n = this._zoneDelegate.intercept(this, e, t),
                            o = this;
                        return function () {
                            return o.runGuarded(n, this, arguments, t);
                        };
                    }
                    run(e, t, n, o) {
                        z = { parent: z, zone: this };
                        try {
                            return this._zoneDelegate.invoke(this, e, t, n, o);
                        } finally {
                            z = z.parent;
                        }
                    }
                    runGuarded(e, t = null, n, o) {
                        z = { parent: z, zone: this };
                        try {
                            try {
                                return this._zoneDelegate.invoke(
                                    this,
                                    e,
                                    t,
                                    n,
                                    o
                                );
                            } catch (r) {
                                if (this._zoneDelegate.handleError(this, r))
                                    throw r;
                            }
                        } finally {
                            z = z.parent;
                        }
                    }
                    runTask(e, t, n) {
                        if (e.zone != this)
                            throw new Error(
                                "A task can only be run in the zone of creation! (Creation: " +
                                    (e.zone || y).name +
                                    "; Execution: " +
                                    this.name +
                                    ")"
                            );
                        if (e.state === v && (e.type === P || e.type === D))
                            return;
                        const o = e.state != E;
                        o && e._transitionTo(E, b), e.runCount++;
                        const r = j;
                        (j = e), (z = { parent: z, zone: this });
                        try {
                            e.type == D &&
                                e.data &&
                                !e.data.isPeriodic &&
                                (e.cancelFn = void 0);
                            try {
                                return this._zoneDelegate.invokeTask(
                                    this,
                                    e,
                                    t,
                                    n
                                );
                            } catch (s) {
                                if (this._zoneDelegate.handleError(this, s))
                                    throw s;
                            }
                        } finally {
                            e.state !== v &&
                                e.state !== Z &&
                                (e.type == P || (e.data && e.data.isPeriodic)
                                    ? o && e._transitionTo(b, E)
                                    : ((e.runCount = 0),
                                      this._updateTaskCount(e, -1),
                                      o && e._transitionTo(v, E, v))),
                                (z = z.parent),
                                (j = r);
                        }
                    }
                    scheduleTask(e) {
                        if (e.zone && e.zone !== this) {
                            let t = this;
                            for (; t; ) {
                                if (t === e.zone)
                                    throw Error(
                                        `can not reschedule task to ${this.name} which is descendants of the original zone ${e.zone.name}`
                                    );
                                t = t.parent;
                            }
                        }
                        e._transitionTo(T, v);
                        const t = [];
                        (e._zoneDelegates = t), (e._zone = this);
                        try {
                            e = this._zoneDelegate.scheduleTask(this, e);
                        } catch (n) {
                            throw (
                                (e._transitionTo(Z, T, v),
                                this._zoneDelegate.handleError(this, n),
                                n)
                            );
                        }
                        return (
                            e._zoneDelegates === t &&
                                this._updateTaskCount(e, 1),
                            e.state == T && e._transitionTo(b, T),
                            e
                        );
                    }
                    scheduleMicroTask(e, t, n, o) {
                        return this.scheduleTask(new u(S, e, t, n, o, void 0));
                    }
                    scheduleMacroTask(e, t, n, o, r) {
                        return this.scheduleTask(new u(D, e, t, n, o, r));
                    }
                    scheduleEventTask(e, t, n, o, r) {
                        return this.scheduleTask(new u(P, e, t, n, o, r));
                    }
                    cancelTask(e) {
                        if (e.zone != this)
                            throw new Error(
                                "A task can only be cancelled in the zone of creation! (Creation: " +
                                    (e.zone || y).name +
                                    "; Execution: " +
                                    this.name +
                                    ")"
                            );
                        e._transitionTo(w, b, E);
                        try {
                            this._zoneDelegate.cancelTask(this, e);
                        } catch (t) {
                            throw (
                                (e._transitionTo(Z, w),
                                this._zoneDelegate.handleError(this, t),
                                t)
                            );
                        }
                        return (
                            this._updateTaskCount(e, -1),
                            e._transitionTo(v, w),
                            (e.runCount = 0),
                            e
                        );
                    }
                    _updateTaskCount(e, t) {
                        const n = e._zoneDelegates;
                        -1 == t && (e._zoneDelegates = null);
                        for (let o = 0; o < n.length; o++)
                            n[o]._updateTaskCount(e.type, t);
                    }
                }
                i.__symbol__ = s;
                const c = {
                    name: "",
                    onHasTask: (e, t, n, o) => e.hasTask(n, o),
                    onScheduleTask: (e, t, n, o) => e.scheduleTask(n, o),
                    onInvokeTask: (e, t, n, o, r, s) =>
                        e.invokeTask(n, o, r, s),
                    onCancelTask: (e, t, n, o) => e.cancelTask(n, o),
                };
                class l {
                    constructor(e, t, n) {
                        (this._taskCounts = {
                            microTask: 0,
                            macroTask: 0,
                            eventTask: 0,
                        }),
                            (this.zone = e),
                            (this._parentDelegate = t),
                            (this._forkZS =
                                n && (n && n.onFork ? n : t._forkZS)),
                            (this._forkDlgt =
                                n && (n.onFork ? t : t._forkDlgt)),
                            (this._forkCurrZone =
                                n && (n.onFork ? this.zone : t._forkCurrZone)),
                            (this._interceptZS =
                                n && (n.onIntercept ? n : t._interceptZS)),
                            (this._interceptDlgt =
                                n && (n.onIntercept ? t : t._interceptDlgt)),
                            (this._interceptCurrZone =
                                n &&
                                (n.onIntercept
                                    ? this.zone
                                    : t._interceptCurrZone)),
                            (this._invokeZS =
                                n && (n.onInvoke ? n : t._invokeZS)),
                            (this._invokeDlgt =
                                n && (n.onInvoke ? t : t._invokeDlgt)),
                            (this._invokeCurrZone =
                                n &&
                                (n.onInvoke ? this.zone : t._invokeCurrZone)),
                            (this._handleErrorZS =
                                n && (n.onHandleError ? n : t._handleErrorZS)),
                            (this._handleErrorDlgt =
                                n &&
                                (n.onHandleError ? t : t._handleErrorDlgt)),
                            (this._handleErrorCurrZone =
                                n &&
                                (n.onHandleError
                                    ? this.zone
                                    : t._handleErrorCurrZone)),
                            (this._scheduleTaskZS =
                                n &&
                                (n.onScheduleTask ? n : t._scheduleTaskZS)),
                            (this._scheduleTaskDlgt =
                                n &&
                                (n.onScheduleTask ? t : t._scheduleTaskDlgt)),
                            (this._scheduleTaskCurrZone =
                                n &&
                                (n.onScheduleTask
                                    ? this.zone
                                    : t._scheduleTaskCurrZone)),
                            (this._invokeTaskZS =
                                n && (n.onInvokeTask ? n : t._invokeTaskZS)),
                            (this._invokeTaskDlgt =
                                n && (n.onInvokeTask ? t : t._invokeTaskDlgt)),
                            (this._invokeTaskCurrZone =
                                n &&
                                (n.onInvokeTask
                                    ? this.zone
                                    : t._invokeTaskCurrZone)),
                            (this._cancelTaskZS =
                                n && (n.onCancelTask ? n : t._cancelTaskZS)),
                            (this._cancelTaskDlgt =
                                n && (n.onCancelTask ? t : t._cancelTaskDlgt)),
                            (this._cancelTaskCurrZone =
                                n &&
                                (n.onCancelTask
                                    ? this.zone
                                    : t._cancelTaskCurrZone)),
                            (this._hasTaskZS = null),
                            (this._hasTaskDlgt = null),
                            (this._hasTaskDlgtOwner = null),
                            (this._hasTaskCurrZone = null);
                        const o = n && n.onHasTask;
                        (o || (t && t._hasTaskZS)) &&
                            ((this._hasTaskZS = o ? n : c),
                            (this._hasTaskDlgt = t),
                            (this._hasTaskDlgtOwner = this),
                            (this._hasTaskCurrZone = e),
                            n.onScheduleTask ||
                                ((this._scheduleTaskZS = c),
                                (this._scheduleTaskDlgt = t),
                                (this._scheduleTaskCurrZone = this.zone)),
                            n.onInvokeTask ||
                                ((this._invokeTaskZS = c),
                                (this._invokeTaskDlgt = t),
                                (this._invokeTaskCurrZone = this.zone)),
                            n.onCancelTask ||
                                ((this._cancelTaskZS = c),
                                (this._cancelTaskDlgt = t),
                                (this._cancelTaskCurrZone = this.zone)));
                    }
                    fork(e, t) {
                        return this._forkZS
                            ? this._forkZS.onFork(
                                  this._forkDlgt,
                                  this.zone,
                                  e,
                                  t
                              )
                            : new i(e, t);
                    }
                    intercept(e, t, n) {
                        return this._interceptZS
                            ? this._interceptZS.onIntercept(
                                  this._interceptDlgt,
                                  this._interceptCurrZone,
                                  e,
                                  t,
                                  n
                              )
                            : t;
                    }
                    invoke(e, t, n, o, r) {
                        return this._invokeZS
                            ? this._invokeZS.onInvoke(
                                  this._invokeDlgt,
                                  this._invokeCurrZone,
                                  e,
                                  t,
                                  n,
                                  o,
                                  r
                              )
                            : t.apply(n, o);
                    }
                    handleError(e, t) {
                        return (
                            !this._handleErrorZS ||
                            this._handleErrorZS.onHandleError(
                                this._handleErrorDlgt,
                                this._handleErrorCurrZone,
                                e,
                                t
                            )
                        );
                    }
                    scheduleTask(e, t) {
                        let n = t;
                        if (this._scheduleTaskZS)
                            this._hasTaskZS &&
                                n._zoneDelegates.push(this._hasTaskDlgtOwner),
                                (n = this._scheduleTaskZS.onScheduleTask(
                                    this._scheduleTaskDlgt,
                                    this._scheduleTaskCurrZone,
                                    e,
                                    t
                                )),
                                n || (n = t);
                        else if (t.scheduleFn) t.scheduleFn(t);
                        else {
                            if (t.type != S)
                                throw new Error("Task is missing scheduleFn.");
                            k(t);
                        }
                        return n;
                    }
                    invokeTask(e, t, n, o) {
                        return this._invokeTaskZS
                            ? this._invokeTaskZS.onInvokeTask(
                                  this._invokeTaskDlgt,
                                  this._invokeTaskCurrZone,
                                  e,
                                  t,
                                  n,
                                  o
                              )
                            : t.callback.apply(n, o);
                    }
                    cancelTask(e, t) {
                        let n;
                        if (this._cancelTaskZS)
                            n = this._cancelTaskZS.onCancelTask(
                                this._cancelTaskDlgt,
                                this._cancelTaskCurrZone,
                                e,
                                t
                            );
                        else {
                            if (!t.cancelFn)
                                throw Error("Task is not cancelable");
                            n = t.cancelFn(t);
                        }
                        return n;
                    }
                    hasTask(e, t) {
                        try {
                            this._hasTaskZS &&
                                this._hasTaskZS.onHasTask(
                                    this._hasTaskDlgt,
                                    this._hasTaskCurrZone,
                                    e,
                                    t
                                );
                        } catch (n) {
                            this.handleError(e, n);
                        }
                    }
                    _updateTaskCount(e, t) {
                        const n = this._taskCounts,
                            o = n[e],
                            r = (n[e] = o + t);
                        if (r < 0)
                            throw new Error(
                                "More tasks executed then were scheduled."
                            );
                        (0 != o && 0 != r) ||
                            this.hasTask(this.zone, {
                                microTask: n.microTask > 0,
                                macroTask: n.macroTask > 0,
                                eventTask: n.eventTask > 0,
                                change: e,
                            });
                    }
                }
                class u {
                    constructor(t, n, o, r, s, a) {
                        if (
                            ((this._zone = null),
                            (this.runCount = 0),
                            (this._zoneDelegates = null),
                            (this._state = "notScheduled"),
                            (this.type = t),
                            (this.source = n),
                            (this.data = r),
                            (this.scheduleFn = s),
                            (this.cancelFn = a),
                            !o)
                        )
                            throw new Error("callback is not defined");
                        this.callback = o;
                        const i = this;
                        this.invoke =
                            t === P && r && r.useG
                                ? u.invokeTask
                                : function () {
                                      return u.invokeTask.call(
                                          e,
                                          i,
                                          this,
                                          arguments
                                      );
                                  };
                    }
                    static invokeTask(e, t, n) {
                        e || (e = this), I++;
                        try {
                            return e.runCount++, e.zone.runTask(e, t, n);
                        } finally {
                            1 == I && m(), I--;
                        }
                    }
                    get zone() {
                        return this._zone;
                    }
                    get state() {
                        return this._state;
                    }
                    cancelScheduleRequest() {
                        this._transitionTo(v, T);
                    }
                    _transitionTo(e, t, n) {
                        if (this._state !== t && this._state !== n)
                            throw new Error(
                                `${this.type} '${
                                    this.source
                                }': can not transition to '${e}', expecting state '${t}'${
                                    n ? " or '" + n + "'" : ""
                                }, was '${this._state}'.`
                            );
                        (this._state = e),
                            e == v && (this._zoneDelegates = null);
                    }
                    toString() {
                        return this.data && void 0 !== this.data.handleId
                            ? this.data.handleId.toString()
                            : Object.prototype.toString.call(this);
                    }
                    toJSON() {
                        return {
                            type: this.type,
                            state: this.state,
                            source: this.source,
                            zone: this.zone.name,
                            runCount: this.runCount,
                        };
                    }
                }
                const h = s("setTimeout"),
                    p = s("Promise"),
                    f = s("then");
                let d,
                    g = [],
                    _ = !1;
                function k(t) {
                    if (0 === I && 0 === g.length)
                        if ((d || (e[p] && (d = e[p].resolve(0))), d)) {
                            let e = d[f];
                            e || (e = d.then), e.call(d, m);
                        } else e[h](m, 0);
                    t && g.push(t);
                }
                function m() {
                    if (!_) {
                        for (_ = !0; g.length; ) {
                            const t = g;
                            g = [];
                            for (let n = 0; n < t.length; n++) {
                                const o = t[n];
                                try {
                                    o.zone.runTask(o, null, null);
                                } catch (e) {
                                    C.onUnhandledError(e);
                                }
                            }
                        }
                        C.microtaskDrainDone(), (_ = !1);
                    }
                }
                const y = { name: "NO ZONE" },
                    v = "notScheduled",
                    T = "scheduling",
                    b = "scheduled",
                    E = "running",
                    w = "canceling",
                    Z = "unknown",
                    S = "microTask",
                    D = "macroTask",
                    P = "eventTask",
                    O = {},
                    C = {
                        symbol: s,
                        currentZoneFrame: () => z,
                        onUnhandledError: R,
                        microtaskDrainDone: R,
                        scheduleMicroTask: k,
                        showUncaughtError: () =>
                            !i[s("ignoreConsoleErrorUncaughtError")],
                        patchEventTarget: () => [],
                        patchOnProperties: R,
                        patchMethod: () => R,
                        bindArguments: () => [],
                        patchThen: () => R,
                        patchMacroTask: () => R,
                        patchEventPrototype: () => R,
                        isIEOrEdge: () => !1,
                        getGlobalObjects: () => {},
                        ObjectDefineProperty: () => R,
                        ObjectGetOwnPropertyDescriptor: () => {},
                        ObjectCreate: () => {},
                        ArraySlice: () => [],
                        patchClass: () => R,
                        wrapWithCurrentZone: () => R,
                        filterProperties: () => [],
                        attachOriginToPatched: () => R,
                        _redefineProperty: () => R,
                        patchCallbacks: () => R,
                    };
                let z = { parent: null, zone: new i(null, null) },
                    j = null,
                    I = 0;
                function R() {}
                o("Zone", "Zone"), (e.Zone = i);
            })(
                ("undefined" != typeof window && window) ||
                    ("undefined" != typeof self && self) ||
                    global
            );
            const n = Object.getOwnPropertyDescriptor,
                o = Object.defineProperty,
                r = Object.getPrototypeOf,
                s = Object.create,
                a = Array.prototype.slice,
                i = Zone.__symbol__("addEventListener"),
                c = Zone.__symbol__("removeEventListener"),
                l = Zone.__symbol__("");
            function u(e, t) {
                return Zone.current.wrap(e, t);
            }
            function h(e, t, n, o, r) {
                return Zone.current.scheduleMacroTask(e, t, n, o, r);
            }
            const p = Zone.__symbol__,
                f = "undefined" != typeof window,
                d = f ? window : void 0,
                g = (f && d) || ("object" == typeof self && self) || global,
                _ = [null];
            function k(e, t) {
                for (let n = e.length - 1; n >= 0; n--)
                    "function" == typeof e[n] && (e[n] = u(e[n], t + "_" + n));
                return e;
            }
            function m(e) {
                return (
                    !e ||
                    (!1 !== e.writable &&
                        !("function" == typeof e.get && void 0 === e.set))
                );
            }
            const y =
                    "undefined" != typeof WorkerGlobalScope &&
                    self instanceof WorkerGlobalScope,
                v =
                    !("nw" in g) &&
                    void 0 !== g.process &&
                    "[object process]" === {}.toString.call(g.process),
                T = !v && !y && !(!f || !d.HTMLElement),
                b =
                    void 0 !== g.process &&
                    "[object process]" === {}.toString.call(g.process) &&
                    !y &&
                    !(!f || !d.HTMLElement),
                E = {},
                w = function (e) {
                    if (!(e = e || g.event)) return;
                    let t = E[e.type];
                    t || (t = E[e.type] = p("ON_PROPERTY" + e.type));
                    const n = this || e.target || g,
                        o = n[t];
                    let r;
                    if (T && n === d && "error" === e.type) {
                        const t = e;
                        (r =
                            o &&
                            o.call(
                                this,
                                t.message,
                                t.filename,
                                t.lineno,
                                t.colno,
                                t.error
                            )),
                            !0 === r && e.preventDefault();
                    } else
                        (r = o && o.apply(this, arguments)),
                            null == r || r || e.preventDefault();
                    return r;
                };
            function Z(e, t, r) {
                let s = n(e, t);
                if (
                    (!s &&
                        r &&
                        n(r, t) &&
                        (s = { enumerable: !0, configurable: !0 }),
                    !s || !s.configurable)
                )
                    return;
                const a = p("on" + t + "patched");
                if (e.hasOwnProperty(a) && e[a]) return;
                delete s.writable, delete s.value;
                const i = s.get,
                    c = s.set,
                    l = t.substr(2);
                let u = E[l];
                u || (u = E[l] = p("ON_PROPERTY" + l)),
                    (s.set = function (t) {
                        let n = this;
                        n || e !== g || (n = g),
                            n &&
                                (n[u] && n.removeEventListener(l, w),
                                c && c.apply(n, _),
                                "function" == typeof t
                                    ? ((n[u] = t), n.addEventListener(l, w, !1))
                                    : (n[u] = null));
                    }),
                    (s.get = function () {
                        let n = this;
                        if ((n || e !== g || (n = g), !n)) return null;
                        const o = n[u];
                        if (o) return o;
                        if (i) {
                            let e = i && i.call(this);
                            if (e)
                                return (
                                    s.set.call(this, e),
                                    "function" == typeof n.removeAttribute &&
                                        n.removeAttribute(t),
                                    e
                                );
                        }
                        return null;
                    }),
                    o(e, t, s),
                    (e[a] = !0);
            }
            function S(e, t, n) {
                if (t) for (let o = 0; o < t.length; o++) Z(e, "on" + t[o], n);
                else {
                    const t = [];
                    for (const n in e) "on" == n.substr(0, 2) && t.push(n);
                    for (let o = 0; o < t.length; o++) Z(e, t[o], n);
                }
            }
            const D = p("originalInstance");
            function P(e) {
                const t = g[e];
                if (!t) return;
                (g[p(e)] = t),
                    (g[e] = function () {
                        const n = k(arguments, e);
                        switch (n.length) {
                            case 0:
                                this[D] = new t();
                                break;
                            case 1:
                                this[D] = new t(n[0]);
                                break;
                            case 2:
                                this[D] = new t(n[0], n[1]);
                                break;
                            case 3:
                                this[D] = new t(n[0], n[1], n[2]);
                                break;
                            case 4:
                                this[D] = new t(n[0], n[1], n[2], n[3]);
                                break;
                            default:
                                throw new Error("Arg list too long.");
                        }
                    }),
                    z(g[e], t);
                const n = new t(function () {});
                let r;
                for (r in n)
                    ("XMLHttpRequest" === e && "responseBlob" === r) ||
                        (function (t) {
                            "function" == typeof n[t]
                                ? (g[e].prototype[t] = function () {
                                      return this[D][t].apply(
                                          this[D],
                                          arguments
                                      );
                                  })
                                : o(g[e].prototype, t, {
                                      set: function (n) {
                                          "function" == typeof n
                                              ? ((this[D][t] = u(
                                                    n,
                                                    e + "." + t
                                                )),
                                                z(this[D][t], n))
                                              : (this[D][t] = n);
                                      },
                                      get: function () {
                                          return this[D][t];
                                      },
                                  });
                        })(r);
                for (r in t)
                    "prototype" !== r &&
                        t.hasOwnProperty(r) &&
                        (g[e][r] = t[r]);
            }
            function O(e, t, o) {
                let s = e;
                for (; s && !s.hasOwnProperty(t); ) s = r(s);
                !s && e[t] && (s = e);
                const a = p(t);
                let i = null;
                if (s && !(i = s[a]) && ((i = s[a] = s[t]), m(s && n(s, t)))) {
                    const e = o(i, a, t);
                    (s[t] = function () {
                        return e(this, arguments);
                    }),
                        z(s[t], i);
                }
                return i;
            }
            function C(e, t, n) {
                let o = null;
                function r(e) {
                    const t = e.data;
                    return (
                        (t.args[t.cbIdx] = function () {
                            e.invoke.apply(this, arguments);
                        }),
                        o.apply(t.target, t.args),
                        e
                    );
                }
                o = O(
                    e,
                    t,
                    (e) =>
                        function (t, o) {
                            const s = n(t, o);
                            return s.cbIdx >= 0 &&
                                "function" == typeof o[s.cbIdx]
                                ? h(s.name, o[s.cbIdx], s, r)
                                : e.apply(t, o);
                        }
                );
            }
            function z(e, t) {
                e[p("OriginalDelegate")] = t;
            }
            let j = !1,
                I = !1;
            function R() {
                try {
                    const e = d.navigator.userAgent;
                    if (
                        -1 !== e.indexOf("MSIE ") ||
                        -1 !== e.indexOf("Trident/")
                    )
                        return !0;
                } catch (e) {}
                return !1;
            }
            function N() {
                if (j) return I;
                j = !0;
                try {
                    const e = d.navigator.userAgent;
                    (-1 === e.indexOf("MSIE ") &&
                        -1 === e.indexOf("Trident/") &&
                        -1 === e.indexOf("Edge/")) ||
                        (I = !0);
                } catch (e) {}
                return I;
            }
            Zone.__load_patch("ZoneAwarePromise", (e, t, n) => {
                const o = Object.getOwnPropertyDescriptor,
                    r = Object.defineProperty,
                    s = n.symbol,
                    a = [],
                    i =
                        !0 ===
                        e[s("DISABLE_WRAPPING_UNCAUGHT_PROMISE_REJECTION")],
                    c = s("Promise"),
                    l = s("then");
                (n.onUnhandledError = (e) => {
                    if (n.showUncaughtError()) {
                        const t = e && e.rejection;
                        t
                            ? console.error(
                                  "Unhandled Promise rejection:",
                                  t instanceof Error ? t.message : t,
                                  "; Zone:",
                                  e.zone.name,
                                  "; Task:",
                                  e.task && e.task.source,
                                  "; Value:",
                                  t,
                                  t instanceof Error ? t.stack : void 0
                              )
                            : console.error(e);
                    }
                }),
                    (n.microtaskDrainDone = () => {
                        for (; a.length; ) {
                            const t = a.shift();
                            try {
                                t.zone.runGuarded(() => {
                                    if (t.throwOriginal) throw t.rejection;
                                    throw t;
                                });
                            } catch (e) {
                                h(e);
                            }
                        }
                    });
                const u = s("unhandledPromiseRejectionHandler");
                function h(e) {
                    n.onUnhandledError(e);
                    try {
                        const n = t[u];
                        "function" == typeof n && n.call(this, e);
                    } catch (o) {}
                }
                function p(e) {
                    return e && e.then;
                }
                function f(e) {
                    return e;
                }
                function d(e) {
                    return D.reject(e);
                }
                const g = s("state"),
                    _ = s("value"),
                    k = s("finally"),
                    m = s("parentPromiseValue"),
                    y = s("parentPromiseState");
                function v(e, t) {
                    return (n) => {
                        try {
                            b(e, t, n);
                        } catch (o) {
                            b(e, !1, o);
                        }
                    };
                }
                const T = s("currentTaskTrace");
                function b(e, o, s) {
                    const c = (function () {
                        let e = !1;
                        return function (t) {
                            return function () {
                                e || ((e = !0), t.apply(null, arguments));
                            };
                        };
                    })();
                    if (e === s)
                        throw new TypeError("Promise resolved with itself");
                    if (null === e[g]) {
                        let h = null;
                        try {
                            ("object" != typeof s && "function" != typeof s) ||
                                (h = s && s.then);
                        } catch (u) {
                            return (
                                c(() => {
                                    b(e, !1, u);
                                })(),
                                e
                            );
                        }
                        if (
                            !1 !== o &&
                            s instanceof D &&
                            s.hasOwnProperty(g) &&
                            s.hasOwnProperty(_) &&
                            null !== s[g]
                        )
                            w(s), b(e, s[g], s[_]);
                        else if (!1 !== o && "function" == typeof h)
                            try {
                                h.call(s, c(v(e, o)), c(v(e, !1)));
                            } catch (u) {
                                c(() => {
                                    b(e, !1, u);
                                })();
                            }
                        else {
                            e[g] = o;
                            const c = e[_];
                            if (
                                ((e[_] = s),
                                e[k] === k &&
                                    !0 === o &&
                                    ((e[g] = e[y]), (e[_] = e[m])),
                                !1 === o && s instanceof Error)
                            ) {
                                const e =
                                    t.currentTask &&
                                    t.currentTask.data &&
                                    t.currentTask.data.__creationTrace__;
                                e &&
                                    r(s, T, {
                                        configurable: !0,
                                        enumerable: !1,
                                        writable: !0,
                                        value: e,
                                    });
                            }
                            for (let t = 0; t < c.length; )
                                Z(e, c[t++], c[t++], c[t++], c[t++]);
                            if (0 == c.length && 0 == o) {
                                e[g] = 0;
                                let o = s;
                                try {
                                    throw new Error(
                                        "Uncaught (in promise): " +
                                            ((l = s) &&
                                            l.toString ===
                                                Object.prototype.toString
                                                ? ((l.constructor &&
                                                      l.constructor.name) ||
                                                      "") +
                                                  ": " +
                                                  JSON.stringify(l)
                                                : l
                                                ? l.toString()
                                                : Object.prototype.toString.call(
                                                      l
                                                  )) +
                                            (s && s.stack ? "\n" + s.stack : "")
                                    );
                                } catch (u) {
                                    o = u;
                                }
                                i && (o.throwOriginal = !0),
                                    (o.rejection = s),
                                    (o.promise = e),
                                    (o.zone = t.current),
                                    (o.task = t.currentTask),
                                    a.push(o),
                                    n.scheduleMicroTask();
                            }
                        }
                    }
                    var l;
                    return e;
                }
                const E = s("rejectionHandledHandler");
                function w(e) {
                    if (0 === e[g]) {
                        try {
                            const n = t[E];
                            n &&
                                "function" == typeof n &&
                                n.call(this, { rejection: e[_], promise: e });
                        } catch (n) {}
                        e[g] = !1;
                        for (let t = 0; t < a.length; t++)
                            e === a[t].promise && a.splice(t, 1);
                    }
                }
                function Z(e, t, n, o, r) {
                    w(e);
                    const s = e[g],
                        a = s
                            ? "function" == typeof o
                                ? o
                                : f
                            : "function" == typeof r
                            ? r
                            : d;
                    t.scheduleMicroTask(
                        "Promise.then",
                        () => {
                            try {
                                const o = e[_],
                                    r = !!n && k === n[k];
                                r && ((n[m] = o), (n[y] = s));
                                const i = t.run(
                                    a,
                                    void 0,
                                    r && a !== d && a !== f ? [] : [o]
                                );
                                b(n, !0, i);
                            } catch (o) {
                                b(n, !1, o);
                            }
                        },
                        n
                    );
                }
                const S = function () {};
                class D {
                    static toString() {
                        return "function ZoneAwarePromise() { [native code] }";
                    }
                    static resolve(e) {
                        return b(new this(null), !0, e);
                    }
                    static reject(e) {
                        return b(new this(null), !1, e);
                    }
                    static race(e) {
                        let t,
                            n,
                            o = new this((e, o) => {
                                (t = e), (n = o);
                            });
                        function r(e) {
                            t(e);
                        }
                        function s(e) {
                            n(e);
                        }
                        for (let a of e)
                            p(a) || (a = this.resolve(a)), a.then(r, s);
                        return o;
                    }
                    static all(e) {
                        return D.allWithCallback(e);
                    }
                    static allSettled(e) {
                        return (
                            this && this.prototype instanceof D ? this : D
                        ).allWithCallback(e, {
                            thenCallback: (e) => ({
                                status: "fulfilled",
                                value: e,
                            }),
                            errorCallback: (e) => ({
                                status: "rejected",
                                reason: e,
                            }),
                        });
                    }
                    static allWithCallback(e, t) {
                        let n,
                            o,
                            r = new this((e, t) => {
                                (n = e), (o = t);
                            }),
                            s = 2,
                            a = 0;
                        const i = [];
                        for (let l of e) {
                            p(l) || (l = this.resolve(l));
                            const e = a;
                            try {
                                l.then(
                                    (o) => {
                                        (i[e] = t ? t.thenCallback(o) : o),
                                            s--,
                                            0 === s && n(i);
                                    },
                                    (r) => {
                                        t
                                            ? ((i[e] = t.errorCallback(r)),
                                              s--,
                                              0 === s && n(i))
                                            : o(r);
                                    }
                                );
                            } catch (c) {
                                o(c);
                            }
                            s++, a++;
                        }
                        return (s -= 2), 0 === s && n(i), r;
                    }
                    constructor(e) {
                        const t = this;
                        if (!(t instanceof D))
                            throw new Error("Must be an instanceof Promise.");
                        (t[g] = null), (t[_] = []);
                        try {
                            e && e(v(t, !0), v(t, !1));
                        } catch (n) {
                            b(t, !1, n);
                        }
                    }
                    get [Symbol.toStringTag]() {
                        return "Promise";
                    }
                    get [Symbol.species]() {
                        return D;
                    }
                    then(e, n) {
                        let o = this.constructor[Symbol.species];
                        (o && "function" == typeof o) ||
                            (o = this.constructor || D);
                        const r = new o(S),
                            s = t.current;
                        return (
                            null == this[g]
                                ? this[_].push(s, r, e, n)
                                : Z(this, s, r, e, n),
                            r
                        );
                    }
                    catch(e) {
                        return this.then(null, e);
                    }
                    finally(e) {
                        let n = this.constructor[Symbol.species];
                        (n && "function" == typeof n) || (n = D);
                        const o = new n(S);
                        o[k] = k;
                        const r = t.current;
                        return (
                            null == this[g]
                                ? this[_].push(r, o, e, e)
                                : Z(this, r, o, e, e),
                            o
                        );
                    }
                }
                (D.resolve = D.resolve),
                    (D.reject = D.reject),
                    (D.race = D.race),
                    (D.all = D.all);
                const P = (e[c] = e.Promise);
                e.Promise = D;
                const C = s("thenPatched");
                function z(e) {
                    const t = e.prototype,
                        n = o(t, "then");
                    if (n && (!1 === n.writable || !n.configurable)) return;
                    const r = t.then;
                    (t[l] = r),
                        (e.prototype.then = function (e, t) {
                            return new D((e, t) => {
                                r.call(this, e, t);
                            }).then(e, t);
                        }),
                        (e[C] = !0);
                }
                return (
                    (n.patchThen = z),
                    P &&
                        (z(P),
                        O(e, "fetch", (e) => {
                            return (
                                (t = e),
                                function (e, n) {
                                    let o = t.apply(e, n);
                                    if (o instanceof D) return o;
                                    let r = o.constructor;
                                    return r[C] || z(r), o;
                                }
                            );
                            var t;
                        })),
                    (Promise[t.__symbol__("uncaughtPromiseErrors")] = a),
                    D
                );
            }),
                Zone.__load_patch("toString", (e) => {
                    const t = Function.prototype.toString,
                        n = p("OriginalDelegate"),
                        o = p("Promise"),
                        r = p("Error"),
                        s = function () {
                            if ("function" == typeof this) {
                                const s = this[n];
                                if (s)
                                    return "function" == typeof s
                                        ? t.call(s)
                                        : Object.prototype.toString.call(s);
                                if (this === Promise) {
                                    const n = e[o];
                                    if (n) return t.call(n);
                                }
                                if (this === Error) {
                                    const n = e[r];
                                    if (n) return t.call(n);
                                }
                            }
                            return t.call(this);
                        };
                    (s[n] = t), (Function.prototype.toString = s);
                    const a = Object.prototype.toString;
                    Object.prototype.toString = function () {
                        return "function" == typeof Promise &&
                            this instanceof Promise
                            ? "[object Promise]"
                            : a.call(this);
                    };
                });
            let x = !1;
            if ("undefined" != typeof window)
                try {
                    const e = Object.defineProperty({}, "passive", {
                        get: function () {
                            x = !0;
                        },
                    });
                    window.addEventListener("test", e, e),
                        window.removeEventListener("test", e, e);
                } catch (le) {
                    x = !1;
                }
            const L = { useG: !0 },
                M = {},
                A = {},
                H = new RegExp("^" + l + "(\\w+)(true|false)$"),
                F = p("propagationStopped");
            function G(e, t) {
                const n = (t ? t(e) : e) + "false",
                    o = (t ? t(e) : e) + "true",
                    r = l + n,
                    s = l + o;
                (M[e] = {}), (M[e].false = r), (M[e].true = s);
            }
            function B(e, t, n) {
                const o = (n && n.add) || "addEventListener",
                    s = (n && n.rm) || "removeEventListener",
                    a = (n && n.listeners) || "eventListeners",
                    i = (n && n.rmAll) || "removeAllListeners",
                    c = p(o),
                    u = "." + o + ":",
                    h = function (e, t, n) {
                        if (e.isRemoved) return;
                        const o = e.callback;
                        "object" == typeof o &&
                            o.handleEvent &&
                            ((e.callback = (e) => o.handleEvent(e)),
                            (e.originalDelegate = o)),
                            e.invoke(e, t, [n]);
                        const r = e.options;
                        r &&
                            "object" == typeof r &&
                            r.once &&
                            t[s].call(
                                t,
                                n.type,
                                e.originalDelegate
                                    ? e.originalDelegate
                                    : e.callback,
                                r
                            );
                    },
                    f = function (t) {
                        if (!(t = t || e.event)) return;
                        const n = this || t.target || e,
                            o = n[M[t.type].false];
                        if (o)
                            if (1 === o.length) h(o[0], n, t);
                            else {
                                const e = o.slice();
                                for (
                                    let o = 0;
                                    o < e.length && (!t || !0 !== t[F]);
                                    o++
                                )
                                    h(e[o], n, t);
                            }
                    },
                    d = function (t) {
                        if (!(t = t || e.event)) return;
                        const n = this || t.target || e,
                            o = n[M[t.type].true];
                        if (o)
                            if (1 === o.length) h(o[0], n, t);
                            else {
                                const e = o.slice();
                                for (
                                    let o = 0;
                                    o < e.length && (!t || !0 !== t[F]);
                                    o++
                                )
                                    h(e[o], n, t);
                            }
                    };
                function g(t, n) {
                    if (!t) return !1;
                    let h = !0;
                    n && void 0 !== n.useG && (h = n.useG);
                    const g = n && n.vh;
                    let _ = !0;
                    n && void 0 !== n.chkDup && (_ = n.chkDup);
                    let k = !1;
                    n && void 0 !== n.rt && (k = n.rt);
                    let m = t;
                    for (; m && !m.hasOwnProperty(o); ) m = r(m);
                    if ((!m && t[o] && (m = t), !m)) return !1;
                    if (m[c]) return !1;
                    const y = n && n.eventNameToString,
                        T = {},
                        b = (m[c] = m[o]),
                        E = (m[p(s)] = m[s]),
                        w = (m[p(a)] = m[a]),
                        Z = (m[p(i)] = m[i]);
                    let S;
                    function D(e, t) {
                        return !x && "object" == typeof e && e
                            ? !!e.capture
                            : x && t
                            ? "boolean" == typeof e
                                ? { capture: e, passive: !0 }
                                : e
                                ? "object" == typeof e && !1 !== e.passive
                                    ? Object.assign(Object.assign({}, e), {
                                          passive: !0,
                                      })
                                    : e
                                : { passive: !0 }
                            : e;
                    }
                    n && n.prepend && (S = m[p(n.prepend)] = m[n.prepend]);
                    const P = h
                            ? function (e) {
                                  if (!T.isExisting)
                                      return b.call(
                                          T.target,
                                          T.eventName,
                                          T.capture ? d : f,
                                          T.options
                                      );
                              }
                            : function (e) {
                                  return b.call(
                                      T.target,
                                      T.eventName,
                                      e.invoke,
                                      T.options
                                  );
                              },
                        O = h
                            ? function (e) {
                                  if (!e.isRemoved) {
                                      const t = M[e.eventName];
                                      let n;
                                      t &&
                                          (n = t[e.capture ? "true" : "false"]);
                                      const o = n && e.target[n];
                                      if (o)
                                          for (let r = 0; r < o.length; r++)
                                              if (o[r] === e) {
                                                  o.splice(r, 1),
                                                      (e.isRemoved = !0),
                                                      0 === o.length &&
                                                          ((e.allRemoved = !0),
                                                          (e.target[n] = null));
                                                  break;
                                              }
                                  }
                                  if (e.allRemoved)
                                      return E.call(
                                          e.target,
                                          e.eventName,
                                          e.capture ? d : f,
                                          e.options
                                      );
                              }
                            : function (e) {
                                  return E.call(
                                      e.target,
                                      e.eventName,
                                      e.invoke,
                                      e.options
                                  );
                              },
                        C =
                            n && n.diff
                                ? n.diff
                                : function (e, t) {
                                      const n = typeof t;
                                      return (
                                          ("function" === n &&
                                              e.callback === t) ||
                                          ("object" === n &&
                                              e.originalDelegate === t)
                                      );
                                  },
                        j = Zone[p("UNPATCHED_EVENTS")],
                        I = e[p("PASSIVE_EVENTS")],
                        R = function (t, o, r, s, a = !1, i = !1) {
                            return function () {
                                const c = this || e;
                                let l = arguments[0];
                                n &&
                                    n.transferEventName &&
                                    (l = n.transferEventName(l));
                                let u = arguments[1];
                                if (!u) return t.apply(this, arguments);
                                if (v && "uncaughtException" === l)
                                    return t.apply(this, arguments);
                                let p = !1;
                                if ("function" != typeof u) {
                                    if (!u.handleEvent)
                                        return t.apply(this, arguments);
                                    p = !0;
                                }
                                if (g && !g(t, u, c, arguments)) return;
                                const f = x && !!I && -1 !== I.indexOf(l),
                                    d = D(arguments[2], f);
                                if (j)
                                    for (let e = 0; e < j.length; e++)
                                        if (l === j[e])
                                            return f
                                                ? t.call(c, l, u, d)
                                                : t.apply(this, arguments);
                                const k =
                                        !!d &&
                                        ("boolean" == typeof d || d.capture),
                                    m = !(!d || "object" != typeof d) && d.once,
                                    b = Zone.current;
                                let E = M[l];
                                E || (G(l, y), (E = M[l]));
                                const w = E[k ? "true" : "false"];
                                let Z,
                                    S = c[w],
                                    P = !1;
                                if (S) {
                                    if (((P = !0), _))
                                        for (let e = 0; e < S.length; e++)
                                            if (C(S[e], u)) return;
                                } else S = c[w] = [];
                                const O = c.constructor.name,
                                    z = A[O];
                                z && (Z = z[l]),
                                    Z || (Z = O + o + (y ? y(l) : l)),
                                    (T.options = d),
                                    m && (T.options.once = !1),
                                    (T.target = c),
                                    (T.capture = k),
                                    (T.eventName = l),
                                    (T.isExisting = P);
                                const R = h ? L : void 0;
                                R && (R.taskData = T);
                                const N = b.scheduleEventTask(Z, u, R, r, s);
                                return (
                                    (T.target = null),
                                    R && (R.taskData = null),
                                    m && (d.once = !0),
                                    (x || "boolean" != typeof N.options) &&
                                        (N.options = d),
                                    (N.target = c),
                                    (N.capture = k),
                                    (N.eventName = l),
                                    p && (N.originalDelegate = u),
                                    i ? S.unshift(N) : S.push(N),
                                    a ? c : void 0
                                );
                            };
                        };
                    return (
                        (m[o] = R(b, u, P, O, k)),
                        S &&
                            (m.prependListener = R(
                                S,
                                ".prependListener:",
                                function (e) {
                                    return S.call(
                                        T.target,
                                        T.eventName,
                                        e.invoke,
                                        T.options
                                    );
                                },
                                O,
                                k,
                                !0
                            )),
                        (m[s] = function () {
                            const t = this || e;
                            let o = arguments[0];
                            n &&
                                n.transferEventName &&
                                (o = n.transferEventName(o));
                            const r = arguments[2],
                                s = !!r && ("boolean" == typeof r || r.capture),
                                a = arguments[1];
                            if (!a) return E.apply(this, arguments);
                            if (g && !g(E, a, t, arguments)) return;
                            const i = M[o];
                            let c;
                            i && (c = i[s ? "true" : "false"]);
                            const u = c && t[c];
                            if (u)
                                for (let e = 0; e < u.length; e++) {
                                    const n = u[e];
                                    if (C(n, a))
                                        return (
                                            u.splice(e, 1),
                                            (n.isRemoved = !0),
                                            0 === u.length &&
                                                ((n.allRemoved = !0),
                                                (t[c] = null),
                                                "string" == typeof o) &&
                                                (t[l + "ON_PROPERTY" + o] =
                                                    null),
                                            n.zone.cancelTask(n),
                                            k ? t : void 0
                                        );
                                }
                            return E.apply(this, arguments);
                        }),
                        (m[a] = function () {
                            const t = this || e;
                            let o = arguments[0];
                            n &&
                                n.transferEventName &&
                                (o = n.transferEventName(o));
                            const r = [],
                                s = q(t, y ? y(o) : o);
                            for (let e = 0; e < s.length; e++) {
                                const t = s[e];
                                r.push(
                                    t.originalDelegate
                                        ? t.originalDelegate
                                        : t.callback
                                );
                            }
                            return r;
                        }),
                        (m[i] = function () {
                            const t = this || e;
                            let o = arguments[0];
                            if (o) {
                                n &&
                                    n.transferEventName &&
                                    (o = n.transferEventName(o));
                                const e = M[o];
                                if (e) {
                                    const n = t[e.false],
                                        r = t[e.true];
                                    if (n) {
                                        const e = n.slice();
                                        for (let t = 0; t < e.length; t++) {
                                            const n = e[t];
                                            this[s].call(
                                                this,
                                                o,
                                                n.originalDelegate
                                                    ? n.originalDelegate
                                                    : n.callback,
                                                n.options
                                            );
                                        }
                                    }
                                    if (r) {
                                        const e = r.slice();
                                        for (let t = 0; t < e.length; t++) {
                                            const n = e[t];
                                            this[s].call(
                                                this,
                                                o,
                                                n.originalDelegate
                                                    ? n.originalDelegate
                                                    : n.callback,
                                                n.options
                                            );
                                        }
                                    }
                                }
                            } else {
                                const e = Object.keys(t);
                                for (let t = 0; t < e.length; t++) {
                                    const n = H.exec(e[t]);
                                    let o = n && n[1];
                                    o &&
                                        "removeListener" !== o &&
                                        this[i].call(this, o);
                                }
                                this[i].call(this, "removeListener");
                            }
                            if (k) return this;
                        }),
                        z(m[o], b),
                        z(m[s], E),
                        Z && z(m[i], Z),
                        w && z(m[a], w),
                        !0
                    );
                }
                let _ = [];
                for (let r = 0; r < t.length; r++) _[r] = g(t[r], n);
                return _;
            }
            function q(e, t) {
                if (!t) {
                    const n = [];
                    for (let o in e) {
                        const r = H.exec(o);
                        let s = r && r[1];
                        if (s && (!t || s === t)) {
                            const t = e[o];
                            if (t)
                                for (let e = 0; e < t.length; e++) n.push(t[e]);
                        }
                    }
                    return n;
                }
                let n = M[t];
                n || (G(t), (n = M[t]));
                const o = e[n.false],
                    r = e[n.true];
                return o ? (r ? o.concat(r) : o.slice()) : r ? r.slice() : [];
            }
            function W(e, t) {
                const n = e.Event;
                n &&
                    n.prototype &&
                    t.patchMethod(
                        n.prototype,
                        "stopImmediatePropagation",
                        (e) =>
                            function (t, n) {
                                (t[F] = !0), e && e.apply(t, n);
                            }
                    );
            }
            function U(e, t, n, o, r) {
                const s = Zone.__symbol__(o);
                if (t[s]) return;
                const a = (t[s] = t[o]);
                (t[o] = function (s, i, c) {
                    return (
                        i &&
                            i.prototype &&
                            r.forEach(function (t) {
                                const r = `${n}.${o}::` + t,
                                    s = i.prototype;
                                if (s.hasOwnProperty(t)) {
                                    const n = e.ObjectGetOwnPropertyDescriptor(
                                        s,
                                        t
                                    );
                                    n && n.value
                                        ? ((n.value = e.wrapWithCurrentZone(
                                              n.value,
                                              r
                                          )),
                                          e._redefineProperty(
                                              i.prototype,
                                              t,
                                              n
                                          ))
                                        : s[t] &&
                                          (s[t] = e.wrapWithCurrentZone(
                                              s[t],
                                              r
                                          ));
                                } else s[t] && (s[t] = e.wrapWithCurrentZone(s[t], r));
                            }),
                        a.call(t, s, i, c)
                    );
                }),
                    e.attachOriginToPatched(t[o], a);
            }
            const V = [
                    "absolutedeviceorientation",
                    "afterinput",
                    "afterprint",
                    "appinstalled",
                    "beforeinstallprompt",
                    "beforeprint",
                    "beforeunload",
                    "devicelight",
                    "devicemotion",
                    "deviceorientation",
                    "deviceorientationabsolute",
                    "deviceproximity",
                    "hashchange",
                    "languagechange",
                    "message",
                    "mozbeforepaint",
                    "offline",
                    "online",
                    "paint",
                    "pageshow",
                    "pagehide",
                    "popstate",
                    "rejectionhandled",
                    "storage",
                    "unhandledrejection",
                    "unload",
                    "userproximity",
                    "vrdisplayconnected",
                    "vrdisplaydisconnected",
                    "vrdisplaypresentchange",
                ],
                X = [
                    "encrypted",
                    "waitingforkey",
                    "msneedkey",
                    "mozinterruptbegin",
                    "mozinterruptend",
                ],
                $ = ["load"],
                J = [
                    "blur",
                    "error",
                    "focus",
                    "load",
                    "resize",
                    "scroll",
                    "messageerror",
                ],
                Y = ["bounce", "finish", "start"],
                K = [
                    "loadstart",
                    "progress",
                    "abort",
                    "error",
                    "load",
                    "progress",
                    "timeout",
                    "loadend",
                    "readystatechange",
                ],
                Q = [
                    "upgradeneeded",
                    "complete",
                    "abort",
                    "success",
                    "error",
                    "blocked",
                    "versionchange",
                    "close",
                ],
                ee = ["close", "error", "open", "message"],
                te = ["error", "message"],
                ne = [
                    "abort",
                    "animationcancel",
                    "animationend",
                    "animationiteration",
                    "auxclick",
                    "beforeinput",
                    "blur",
                    "cancel",
                    "canplay",
                    "canplaythrough",
                    "change",
                    "compositionstart",
                    "compositionupdate",
                    "compositionend",
                    "cuechange",
                    "click",
                    "close",
                    "contextmenu",
                    "curechange",
                    "dblclick",
                    "drag",
                    "dragend",
                    "dragenter",
                    "dragexit",
                    "dragleave",
                    "dragover",
                    "drop",
                    "durationchange",
                    "emptied",
                    "ended",
                    "error",
                    "focus",
                    "focusin",
                    "focusout",
                    "gotpointercapture",
                    "input",
                    "invalid",
                    "keydown",
                    "keypress",
                    "keyup",
                    "load",
                    "loadstart",
                    "loadeddata",
                    "loadedmetadata",
                    "lostpointercapture",
                    "mousedown",
                    "mouseenter",
                    "mouseleave",
                    "mousemove",
                    "mouseout",
                    "mouseover",
                    "mouseup",
                    "mousewheel",
                    "orientationchange",
                    "pause",
                    "play",
                    "playing",
                    "pointercancel",
                    "pointerdown",
                    "pointerenter",
                    "pointerleave",
                    "pointerlockchange",
                    "mozpointerlockchange",
                    "webkitpointerlockerchange",
                    "pointerlockerror",
                    "mozpointerlockerror",
                    "webkitpointerlockerror",
                    "pointermove",
                    "pointout",
                    "pointerover",
                    "pointerup",
                    "progress",
                    "ratechange",
                    "reset",
                    "resize",
                    "scroll",
                    "seeked",
                    "seeking",
                    "select",
                    "selectionchange",
                    "selectstart",
                    "show",
                    "sort",
                    "stalled",
                    "submit",
                    "suspend",
                    "timeupdate",
                    "volumechange",
                    "touchcancel",
                    "touchmove",
                    "touchstart",
                    "touchend",
                    "transitioncancel",
                    "transitionend",
                    "waiting",
                    "wheel",
                ].concat(
                    [
                        "webglcontextrestored",
                        "webglcontextlost",
                        "webglcontextcreationerror",
                    ],
                    ["autocomplete", "autocompleteerror"],
                    ["toggle"],
                    [
                        "afterscriptexecute",
                        "beforescriptexecute",
                        "DOMContentLoaded",
                        "freeze",
                        "fullscreenchange",
                        "mozfullscreenchange",
                        "webkitfullscreenchange",
                        "msfullscreenchange",
                        "fullscreenerror",
                        "mozfullscreenerror",
                        "webkitfullscreenerror",
                        "msfullscreenerror",
                        "readystatechange",
                        "visibilitychange",
                        "resume",
                    ],
                    V,
                    [
                        "beforecopy",
                        "beforecut",
                        "beforepaste",
                        "copy",
                        "cut",
                        "paste",
                        "dragstart",
                        "loadend",
                        "animationstart",
                        "search",
                        "transitionrun",
                        "transitionstart",
                        "webkitanimationend",
                        "webkitanimationiteration",
                        "webkitanimationstart",
                        "webkittransitionend",
                    ],
                    [
                        "activate",
                        "afterupdate",
                        "ariarequest",
                        "beforeactivate",
                        "beforedeactivate",
                        "beforeeditfocus",
                        "beforeupdate",
                        "cellchange",
                        "controlselect",
                        "dataavailable",
                        "datasetchanged",
                        "datasetcomplete",
                        "errorupdate",
                        "filterchange",
                        "layoutcomplete",
                        "losecapture",
                        "move",
                        "moveend",
                        "movestart",
                        "propertychange",
                        "resizeend",
                        "resizestart",
                        "rowenter",
                        "rowexit",
                        "rowsdelete",
                        "rowsinserted",
                        "command",
                        "compassneedscalibration",
                        "deactivate",
                        "help",
                        "mscontentzoom",
                        "msmanipulationstatechanged",
                        "msgesturechange",
                        "msgesturedoubletap",
                        "msgestureend",
                        "msgesturehold",
                        "msgesturestart",
                        "msgesturetap",
                        "msgotpointercapture",
                        "msinertiastart",
                        "mslostpointercapture",
                        "mspointercancel",
                        "mspointerdown",
                        "mspointerenter",
                        "mspointerhover",
                        "mspointerleave",
                        "mspointermove",
                        "mspointerout",
                        "mspointerover",
                        "mspointerup",
                        "pointerout",
                        "mssitemodejumplistitemremoved",
                        "msthumbnailclick",
                        "stop",
                        "storagecommit",
                    ]
                );
            function oe(e, t, n) {
                if (!n || 0 === n.length) return t;
                const o = n.filter((t) => t.target === e);
                if (!o || 0 === o.length) return t;
                const r = o[0].ignoreProperties;
                return t.filter((e) => -1 === r.indexOf(e));
            }
            function re(e, t, n, o) {
                e && S(e, oe(e, t, n), o);
            }
            function se(e, t) {
                if (v && !b) return;
                if (Zone[e.symbol("patchEvents")]) return;
                const n = "undefined" != typeof WebSocket,
                    o = t.__Zone_ignore_on_properties;
                if (T) {
                    const e = window,
                        t = R()
                            ? [{ target: e, ignoreProperties: ["error"] }]
                            : [];
                    re(
                        e,
                        ne.concat(["messageerror"]),
                        o ? o.concat(t) : o,
                        r(e)
                    ),
                        re(Document.prototype, ne, o),
                        void 0 !== e.SVGElement &&
                            re(e.SVGElement.prototype, ne, o),
                        re(Element.prototype, ne, o),
                        re(HTMLElement.prototype, ne, o),
                        re(HTMLMediaElement.prototype, X, o),
                        re(HTMLFrameSetElement.prototype, V.concat(J), o),
                        re(HTMLBodyElement.prototype, V.concat(J), o),
                        re(HTMLFrameElement.prototype, $, o),
                        re(HTMLIFrameElement.prototype, $, o);
                    const n = e.HTMLMarqueeElement;
                    n && re(n.prototype, Y, o);
                    const s = e.Worker;
                    s && re(s.prototype, te, o);
                }
                const s = t.XMLHttpRequest;
                s && re(s.prototype, K, o);
                const a = t.XMLHttpRequestEventTarget;
                a && re(a && a.prototype, K, o),
                    "undefined" != typeof IDBIndex &&
                        (re(IDBIndex.prototype, Q, o),
                        re(IDBRequest.prototype, Q, o),
                        re(IDBOpenDBRequest.prototype, Q, o),
                        re(IDBDatabase.prototype, Q, o),
                        re(IDBTransaction.prototype, Q, o),
                        re(IDBCursor.prototype, Q, o)),
                    n && re(WebSocket.prototype, ee, o);
            }
            Zone.__load_patch("util", (e, t, r) => {
                (r.patchOnProperties = S),
                    (r.patchMethod = O),
                    (r.bindArguments = k),
                    (r.patchMacroTask = C);
                const i = t.__symbol__("BLACK_LISTED_EVENTS"),
                    c = t.__symbol__("UNPATCHED_EVENTS");
                e[c] && (e[i] = e[c]),
                    e[i] && (t[i] = t[c] = e[i]),
                    (r.patchEventPrototype = W),
                    (r.patchEventTarget = B),
                    (r.isIEOrEdge = N),
                    (r.ObjectDefineProperty = o),
                    (r.ObjectGetOwnPropertyDescriptor = n),
                    (r.ObjectCreate = s),
                    (r.ArraySlice = a),
                    (r.patchClass = P),
                    (r.wrapWithCurrentZone = u),
                    (r.filterProperties = oe),
                    (r.attachOriginToPatched = z),
                    (r._redefineProperty = Object.defineProperty),
                    (r.patchCallbacks = U),
                    (r.getGlobalObjects = () => ({
                        globalSources: A,
                        zoneSymbolEventNames: M,
                        eventNames: ne,
                        isBrowser: T,
                        isMix: b,
                        isNode: v,
                        TRUE_STR: "true",
                        FALSE_STR: "false",
                        ZONE_SYMBOL_PREFIX: l,
                        ADD_EVENT_LISTENER_STR: "addEventListener",
                        REMOVE_EVENT_LISTENER_STR: "removeEventListener",
                    }));
            });
            const ae = p("zoneTask");
            function ie(e, t, n, o) {
                let r = null,
                    s = null;
                n += o;
                const a = {};
                function i(t) {
                    const n = t.data;
                    return (
                        (n.args[0] = function () {
                            try {
                                t.invoke.apply(this, arguments);
                            } finally {
                                (t.data && t.data.isPeriodic) ||
                                    ("number" == typeof n.handleId
                                        ? delete a[n.handleId]
                                        : n.handleId &&
                                          (n.handleId[ae] = null));
                            }
                        }),
                        (n.handleId = r.apply(e, n.args)),
                        t
                    );
                }
                function c(t) {
                    return s.call(e, t.data.handleId);
                }
                (r = O(
                    e,
                    (t += o),
                    (n) =>
                        function (r, s) {
                            if ("function" == typeof s[0]) {
                                const e = h(
                                    t,
                                    s[0],
                                    {
                                        isPeriodic: "Interval" === o,
                                        delay:
                                            "Timeout" === o || "Interval" === o
                                                ? s[1] || 0
                                                : void 0,
                                        args: s,
                                    },
                                    i,
                                    c
                                );
                                if (!e) return e;
                                const n = e.data.handleId;
                                return (
                                    "number" == typeof n
                                        ? (a[n] = e)
                                        : n && (n[ae] = e),
                                    n &&
                                        n.ref &&
                                        n.unref &&
                                        "function" == typeof n.ref &&
                                        "function" == typeof n.unref &&
                                        ((e.ref = n.ref.bind(n)),
                                        (e.unref = n.unref.bind(n))),
                                    "number" == typeof n || n ? n : e
                                );
                            }
                            return n.apply(e, s);
                        }
                )),
                    (s = O(
                        e,
                        n,
                        (t) =>
                            function (n, o) {
                                const r = o[0];
                                let s;
                                "number" == typeof r
                                    ? (s = a[r])
                                    : ((s = r && r[ae]), s || (s = r)),
                                    s && "string" == typeof s.type
                                        ? "notScheduled" !== s.state &&
                                          ((s.cancelFn && s.data.isPeriodic) ||
                                              0 === s.runCount) &&
                                          ("number" == typeof r
                                              ? delete a[r]
                                              : r && (r[ae] = null),
                                          s.zone.cancelTask(s))
                                        : t.apply(e, o);
                            }
                    ));
            }
            function ce(e, t) {
                if (Zone[t.symbol("patchEventTarget")]) return;
                const {
                    eventNames: n,
                    zoneSymbolEventNames: o,
                    TRUE_STR: r,
                    FALSE_STR: s,
                    ZONE_SYMBOL_PREFIX: a,
                } = t.getGlobalObjects();
                for (let c = 0; c < n.length; c++) {
                    const e = n[c],
                        t = a + (e + s),
                        i = a + (e + r);
                    (o[e] = {}), (o[e][s] = t), (o[e][r] = i);
                }
                const i = e.EventTarget;
                return i && i.prototype
                    ? (t.patchEventTarget(e, [i && i.prototype]), !0)
                    : void 0;
            }
            Zone.__load_patch("legacy", (e) => {
                const t = e[Zone.__symbol__("legacyPatch")];
                t && t();
            }),
                Zone.__load_patch("timers", (e) => {
                    ie(e, "set", "clear", "Timeout"),
                        ie(e, "set", "clear", "Interval"),
                        ie(e, "set", "clear", "Immediate");
                }),
                Zone.__load_patch("requestAnimationFrame", (e) => {
                    ie(e, "request", "cancel", "AnimationFrame"),
                        ie(e, "mozRequest", "mozCancel", "AnimationFrame"),
                        ie(
                            e,
                            "webkitRequest",
                            "webkitCancel",
                            "AnimationFrame"
                        );
                }),
                Zone.__load_patch("blocking", (e, t) => {
                    const n = ["alert", "prompt", "confirm"];
                    for (let o = 0; o < n.length; o++)
                        O(
                            e,
                            n[o],
                            (n, o, r) =>
                                function (o, s) {
                                    return t.current.run(n, e, s, r);
                                }
                        );
                }),
                Zone.__load_patch("EventTarget", (e, t, n) => {
                    !(function (e, t) {
                        t.patchEventPrototype(e, t);
                    })(e, n),
                        ce(e, n);
                    const o = e.XMLHttpRequestEventTarget;
                    o && o.prototype && n.patchEventTarget(e, [o.prototype]);
                }),
                Zone.__load_patch("MutationObserver", (e, t, n) => {
                    P("MutationObserver"), P("WebKitMutationObserver");
                }),
                Zone.__load_patch("IntersectionObserver", (e, t, n) => {
                    P("IntersectionObserver");
                }),
                Zone.__load_patch("FileReader", (e, t, n) => {
                    P("FileReader");
                }),
                Zone.__load_patch("on_property", (e, t, n) => {
                    se(n, e);
                }),
                Zone.__load_patch("customElements", (e, t, n) => {
                    !(function (e, t) {
                        const { isBrowser: n, isMix: o } = t.getGlobalObjects();
                        (n || o) &&
                            e.customElements &&
                            "customElements" in e &&
                            t.patchCallbacks(
                                t,
                                e.customElements,
                                "customElements",
                                "define",
                                [
                                    "connectedCallback",
                                    "disconnectedCallback",
                                    "adoptedCallback",
                                    "attributeChangedCallback",
                                ]
                            );
                    })(e, n);
                }),
                Zone.__load_patch("XHR", (e, t) => {
                    !(function (e) {
                        const u = e.XMLHttpRequest;
                        if (!u) return;
                        const f = u.prototype;
                        let d = f[i],
                            g = f[c];
                        if (!d) {
                            const t = e.XMLHttpRequestEventTarget;
                            if (t) {
                                const e = t.prototype;
                                (d = e[i]), (g = e[c]);
                            }
                        }
                        function _(e) {
                            const o = e.data,
                                a = o.target;
                            (a[s] = !1), (a[l] = !1);
                            const u = a[r];
                            d || ((d = a[i]), (g = a[c])),
                                u && g.call(a, "readystatechange", u);
                            const h = (a[r] = () => {
                                if (a.readyState === a.DONE)
                                    if (
                                        !o.aborted &&
                                        a[s] &&
                                        "scheduled" === e.state
                                    ) {
                                        const n = a[t.__symbol__("loadfalse")];
                                        if (
                                            0 !== a.status &&
                                            n &&
                                            n.length > 0
                                        ) {
                                            const r = e.invoke;
                                            (e.invoke = function () {
                                                const n =
                                                    a[
                                                        t.__symbol__(
                                                            "loadfalse"
                                                        )
                                                    ];
                                                for (
                                                    let t = 0;
                                                    t < n.length;
                                                    t++
                                                )
                                                    n[t] === e &&
                                                        n.splice(t, 1);
                                                o.aborted ||
                                                    "scheduled" !== e.state ||
                                                    r.call(e);
                                            }),
                                                n.push(e);
                                        } else e.invoke();
                                    } else
                                        o.aborted || !1 !== a[s] || (a[l] = !0);
                            });
                            return (
                                d.call(a, "readystatechange", h),
                                a[n] || (a[n] = e),
                                b.apply(a, o.args),
                                (a[s] = !0),
                                e
                            );
                        }
                        function k() {}
                        function m(e) {
                            const t = e.data;
                            return (t.aborted = !0), E.apply(t.target, t.args);
                        }
                        const y = O(
                                f,
                                "open",
                                () =>
                                    function (e, t) {
                                        return (
                                            (e[o] = 0 == t[2]),
                                            (e[a] = t[1]),
                                            y.apply(e, t)
                                        );
                                    }
                            ),
                            v = p("fetchTaskAborting"),
                            T = p("fetchTaskScheduling"),
                            b = O(
                                f,
                                "send",
                                () =>
                                    function (e, n) {
                                        if (!0 === t.current[T])
                                            return b.apply(e, n);
                                        if (e[o]) return b.apply(e, n);
                                        {
                                            const t = {
                                                    target: e,
                                                    url: e[a],
                                                    isPeriodic: !1,
                                                    args: n,
                                                    aborted: !1,
                                                },
                                                o = h(
                                                    "XMLHttpRequest.send",
                                                    k,
                                                    t,
                                                    _,
                                                    m
                                                );
                                            e &&
                                                !0 === e[l] &&
                                                !t.aborted &&
                                                "scheduled" === o.state &&
                                                o.invoke();
                                        }
                                    }
                            ),
                            E = O(
                                f,
                                "abort",
                                () =>
                                    function (e, o) {
                                        const r = e[n];
                                        if (r && "string" == typeof r.type) {
                                            if (
                                                null == r.cancelFn ||
                                                (r.data && r.data.aborted)
                                            )
                                                return;
                                            r.zone.cancelTask(r);
                                        } else if (!0 === t.current[v])
                                            return E.apply(e, o);
                                    }
                            );
                    })(e);
                    const n = p("xhrTask"),
                        o = p("xhrSync"),
                        r = p("xhrListener"),
                        s = p("xhrScheduled"),
                        a = p("xhrURL"),
                        l = p("xhrErrorBeforeScheduled");
                }),
                Zone.__load_patch("geolocation", (e) => {
                    e.navigator &&
                        e.navigator.geolocation &&
                        (function (e, t) {
                            const o = e.constructor.name;
                            for (let r = 0; r < t.length; r++) {
                                const s = t[r],
                                    a = e[s];
                                if (a) {
                                    if (!m(n(e, s))) continue;
                                    e[s] = ((e) => {
                                        const t = function () {
                                            return e.apply(
                                                this,
                                                k(arguments, o + "." + s)
                                            );
                                        };
                                        return z(t, e), t;
                                    })(a);
                                }
                            }
                        })(e.navigator.geolocation, [
                            "getCurrentPosition",
                            "watchPosition",
                        ]);
                }),
                Zone.__load_patch("PromiseRejectionEvent", (e, t) => {
                    function n(t) {
                        return function (n) {
                            q(e, t).forEach((o) => {
                                const r = e.PromiseRejectionEvent;
                                if (r) {
                                    const e = new r(t, {
                                        promise: n.promise,
                                        reason: n.rejection,
                                    });
                                    o.invoke(e);
                                }
                            });
                        };
                    }
                    e.PromiseRejectionEvent &&
                        ((t[p("unhandledPromiseRejectionHandler")] =
                            n("unhandledrejection")),
                        (t[p("rejectionHandledHandler")] =
                            n("rejectionhandled")));
                });
        },
    },
    [[2, 0]],
]);
!(function (e) {
    function r(r) {
        for (
            var n, i, l = r[0], f = r[1], p = r[2], c = 0, s = [];
            c < l.length;
            c++
        )
            (i = l[c]),
                Object.prototype.hasOwnProperty.call(o, i) &&
                    o[i] &&
                    s.push(o[i][0]),
                (o[i] = 0);
        for (n in f)
            Object.prototype.hasOwnProperty.call(f, n) && (e[n] = f[n]);
        for (a && a(r); s.length; ) s.shift()();
        return u.push.apply(u, p || []), t();
    }
    function t() {
        for (var e, r = 0; r < u.length; r++) {
            for (var t = u[r], n = !0, l = 1; l < t.length; l++)
                0 !== o[t[l]] && (n = !1);
            n && (u.splice(r--, 1), (e = i((i.s = t[0]))));
        }
        return e;
    }
    var n = {},
        o = { 0: 0 },
        u = [];
    function i(r) {
        if (n[r]) return n[r].exports;
        var t = (n[r] = { i: r, l: !1, exports: {} });
        return e[r].call(t.exports, t, t.exports, i), (t.l = !0), t.exports;
    }
    (i.m = e),
        (i.c = n),
        (i.d = function (e, r, t) {
            i.o(e, r) ||
                Object.defineProperty(e, r, { enumerable: !0, get: t });
        }),
        (i.r = function (e) {
            "undefined" != typeof Symbol &&
                Symbol.toStringTag &&
                Object.defineProperty(e, Symbol.toStringTag, {
                    value: "Module",
                }),
                Object.defineProperty(e, "__esModule", { value: !0 });
        }),
        (i.t = function (e, r) {
            if ((1 & r && (e = i(e)), 8 & r)) return e;
            if (4 & r && "object" == typeof e && e && e.__esModule) return e;
            var t = Object.create(null);
            if (
                (i.r(t),
                Object.defineProperty(t, "default", {
                    enumerable: !0,
                    value: e,
                }),
                2 & r && "string" != typeof e)
            )
                for (var n in e)
                    i.d(
                        t,
                        n,
                        function (r) {
                            return e[r];
                        }.bind(null, n)
                    );
            return t;
        }),
        (i.n = function (e) {
            var r =
                e && e.__esModule
                    ? function () {
                          return e.default;
                      }
                    : function () {
                          return e;
                      };
            return i.d(r, "a", r), r;
        }),
        (i.o = function (e, r) {
            return Object.prototype.hasOwnProperty.call(e, r);
        }),
        (i.p = "");
    var l = (window.webpackJsonpSBCustomizer =
            window.webpackJsonpSBCustomizer || []),
        f = l.push.bind(l);
    (l.push = r), (l = l.slice());
    for (var p = 0; p < l.length; p++) r(l[p]);
    var a = f;
    t();
})([]);
